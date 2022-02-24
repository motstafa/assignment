<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Questions;
use Validator;
use App\Models\personal_access_tokens;
use App\Models\surveyQuestions;
class surveyController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'Name' => 'required',
                'countryId' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(["status"=>"Validation Error"]);      
            }
        Survey::firstOrCreate($request->all());
        }
        catch(\Exception $e)
        {
            return response()->json(["status"=>$e],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $auditId=personal_access_tokens::where('token',request()->user()->currentAccessToken()->token)->first('tokenable_id');
        $actualAuditid= Survey::where('id',$id)->first('idAudit');
        
        if($auditId->tokenable_id!=$actualAuditid->idAudit)
        {
            return response()->json(["status"=>"you are authorized to access this survey"],400);
        }
        $tempdocument=array();
        $priority=0;
        $response=array();
        $response['assessment']=array();
       $questions= 
       Questions::join("survey_questions","questions.id","survey_questions.questionId")
       ->leftjoin("documents","questions.document_id","documents.id")
       ->where("survey_questions.surveyId",$id)->orderBy('survey_questions.priority')
       ->get(['questions.document_id','survey_questions.questionId','survey_questions.priority','documents.document','questions.document_id','questions.text']);
       foreach($questions as $question)
       {
           if($priority==0 || $priority!=$question->priority)
           { 
             if($priority!=0)
             {
                array_push($response['assessment'],$tempdocument);
             }
             $tempdocument['questions']=array();
             if($question->document_id==null)
             {
               $tempdocument['document']=null;
             }else
             {
                $tempdocument['document']=$question->document;
             }
             $priority=$question->priority;
           }
           array_push($tempdocument['questions'],$question->text);
          /* if($question->document_id==null)
           {
             array_push($response['questions without documents'],$question->text);
           }
           else{
               if($documentid==0 || $documentid!=$question->document_id)
               {
                   if($documentid!=0){
                    array_push($response['document with questions'],$tempdocument);
                   }
                $documentid=$question->document_id;
                $tempdocument['document']=$question->document;
                $tempdocument['questions']=array();
              }
            array_push($tempdocument['questions'],$question->text);
           }*/
       }
     array_push($response['assessment'],$tempdocument);
    return $response;
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
