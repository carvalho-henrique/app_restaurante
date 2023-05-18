<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function __construct(Reservation $reservation){
        $this->reservation = $reservation;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservation =  $this->reservation::with('user')->get();

        return response()->json($reservation, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->reservation->rules(), $this->reservation->feedback());

        //Validação para não colocar dia anterior ao hoje
        if(date('Y-m-d') == date($request->reservation_date)){
            return response()->json(['erro' => 'Data Invalida!'], 422);
        }

        //Validação para os domingos
        if(date('w', strtotime($request->reservation_date)) == 0){
            return response()->json(['erro' => 'Restaurante não abre aos domingos!'], 400);
        }

        //Validação de horario
        if (!(strtotime($request->start_time) >= strtotime('18:00') 
            && ( strtotime($request->end_time) >= strtotime('18:00')
                 && strtotime($request->end_time) <= strtotime('23:59') 
                )
        )) {
            return response()->json(['erro' => 'Horario de funcionamento do restaurante é das 18:00 - 23:59'], 400);
        }

        //Verificar se o usuario já tem reserva no dia
        $validation_date = $this->reservation::where('user_id', $request->user_id)
                                                ->where('reservation_date', $request->reservation_date)->get();

        if($validation_date->isNotEmpty()){
            return response()->json(['erro' => 'Já existe uma reserva neste dia em seu usuário!'], 409);
        }

        
        //Verificar conflitos de horarios
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $validation_hours = $this->reservation::where('reservation_date', $request->reservation_date)
                                                ->where(function ($query) use ($start_time, $end_time) {
                                                    $query->whereRaw("CAST(start_time as time) >= '$start_time'")
                                                        ->orWhereRaw("CAST(end_time as time) < '$end_time'");
                                                    });

        if($validation_hours->count() >= 15){
            return response()->json(['erro' => 'Não possuimos reservas neste horario!'], 409);
        }
        
        $reservation = $this->reservation->create([
            'user_id' => $request->user_id,
            'number_people' => $request->number_people,
            'reservation_date' => $request->reservation_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json($reservation, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = $this->reservation->find($id);
        if($reservation === null){
            return response()->json(['erro' => 'recurso pesquisado não existe'], 404);
        }
        return response()->json($reservation, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = $this->reservation->find($id);
        if($reservation === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização'], 404);

        }
        if($request->method() === 'PATCH'){
            $dynamicRules = array();
            foreach ($reservation->rules() as $input => $rule) {
                if(array_key_exists($input, $request->all())){
                    $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules);
        } else {
            $request->validate($reservation->rules());
        }

        $reservation->fill($request->all());
        $reservation->save();

        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = $this->reservation->find($id);
        if($reservation === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão.'], 404);
        }

        $reservation->delete();
        return response()->json(['msg' => 'Exlusão feita com sucesso.'], 200);
    }
}
