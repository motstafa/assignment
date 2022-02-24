<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answers;
use Validator;
class answersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'idSurvey' => 'required',
                'answers'=>'required',
            ]);
            if($validator->fails()){
                return response()->json(["status"=>"Validation Error"]);      
            }
            foreach($request['answers'] as $answer)
            {
               if(! Answers::firstOrCreate(["idUser"=>$request['idUser'],"idSurvey"=>$request['idSurvey'],
                "questionId"=>$answer['questionId'],"userAnswers"=>$answer['userAnswers']]))
                {
                    return response()->json(false,204);
                }
            }
            return response()->json(["status"=>"object created"],201);
        }
        catch(\Exception $e)
        {
          return response()->json($e,400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($surveyID,$idUser)
    {
        try{
            return json_encode(Answers::join('questions','questions.id','answers.questionId')->where(["answers.idSurvey"=>$surveyID,"answers.idUser"=>$idUser])->get(["answers.idUser"
            ,"answers.idSurvey","answers.questionId","questions.givenAnswer","answers.score","answers.userAnswers","answers.commentid"]));
        }
        catch(\Exception)
        {
            return response()->json(["status"=>"object not found"],400);
        }
    }

     
    public function addScores(Request $request)
    {
       try{
           foreach($request['scores'] as $score)
           {
               if(!
          Answers::where(["idUser"=>$score['idUser'],
          "idSurvey"=>$score['idSurvey'],"questionId"=>$score['questionId']])
          ->update(['score'=>$score['score']]))
        {return response()->json(["status"=>"can't add score"],400); }    
        
        }
        return response()->json(["status"=>"scores added scucessfully"],200); 
       }
       catch(\Exception $e)
       {

       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}



