<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstRtoAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RtoAgentController extends Controller
{
    public function index(Request $request){
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.rto.agent.index');
        }else{
            $agents = MstRtoAgent::
            AgentSearch($request)
            ->EmailSearch($request)
            ->PhoneSearch($request)
            ->LocationSearch($request)
            ->orderBy('id','desc')
            ->paginate($request->limit ? $request->limit : 10);
            return view('admin.master.rto_agent.index')->with([
                'agents' => $agents
            ]);
        }
    }

    public function create(){
        return view('admin.master.rto_agent.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'agent' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('mst_rto_agents')->ignore($request->id),
            ],
            'phone_number' => 'required',
            'location' => 'required',
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                $type = MstRtoAgent::find($request->id);
                $type->update($request->except('_token'));
            } else {
                MstRtoAgent::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('rto agent successfully saved'));
            return redirect()->route('admin.master.rto.agent.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }

    }

    public function show($id){
        $agent = MstRtoAgent::find($id);
        return view('admin.master.rto_agent.create', compact('agent'));
    }

    public function delete($id){
        $agent = MstRtoAgent::find($id);
        $agent->delete();

        \toastr()->success(ucfirst('rto agent successfully deleted'));
        return redirect()->back();
    }

    public function view($id){
        $agent = MstRtoAgent::find($id);
        return view('admin.master.rto_agent.view', compact('agent'));
    }

    public function status($id, $status){
        $party = MstRtoAgent::find($id);
        $updateStatus = ($status == 1) ? 0 : 1;
        $message = ($status == 0) ? 'Agent activated successfully' : 'Agent deactivated successfully';

        $party->update(['status' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

}
