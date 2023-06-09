<?php

namespace App\Services;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Faker\Factory;
use Illuminate\Http\Request;

class ContactService
{
    public function get(Request $request)
    {
        $search = null;
        if(!empty($request->search)){

            if($request->type === "contact"){
                $search = Contact::where($request->type, 'like', '%'. strtolower($request->search).'%')->get();
            }else {
                $search = Contact::whereRaw("lower(" . $request->type . ") like '%" . strtolower($request->search) . "%'")->get();
            }
        }

        return ($search ?? Contact::get());
    }
    public function trashed(Request $request)
    {
        $search = null;
        if(!empty($request->search)) {
            if($request->type === "contact"){
                $search = Contact::onlyTrashed()
                    ->where($request->type, 'like', '%'. strtolower($request->search).'%')->get();
            }else {
                $search = Contact::onlyTrashed()
                    ->whereRaw("lower(" . $request->type . ") like '%" . strtolower($request->search) . "%'")->get();
            }
        }
        return ($search ?? Contact::onlyTrashed()->get());
    }
    public function restore($id)
    {
        try {
            $contact = Contact::withTrashed()->find($id);

            if ($contact->doesntExist())
                return response()->json([
                    'status' => false,
                    'message' => 'O contato informado não existe.'
                ]);

            $restore = $contact->restore();

            if ($restore)
                return response()->json([
                    'status' => true,
                    'message' => 'Contato restaurado com sucesso!',
                    'data' => Contact::onlyTrashed()->get()
                ]);
        }catch (\PDOException $e){
            return response()->json([
                'status' => false,
                'message' => 'falha ao executar a ação',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(ContactStoreRequest $request)
    {
        try{

            $faker = Factory::create();
            $store = $request->validated();
            $store['image'] =  "/images/".$faker->image(public_path("images"), 120, 120, null,false);

            $contact = Contact::create($store);

            return response()->json([
                'status' =>($contact ? true : false),
                'message' => 'Contato criado com sucesso!',
                'data' => Contact::get()
            ]);

        }catch (\PDOException $e){
            return response()->json([
                'status' => false,
                'message' => 'falha ao executar a ação',
                'error' => $e->getMessage()
            ]);
        }

    }

    public function update(ContactUpdateRequest $request, $id)
    {
        try{
            $contact = Contact::whereId($id);

            if ($contact->doesntExist())
                return response()->json([
                    'status' => false,
                    'message' => 'O contato informado não existe.'
                ]);

            $contact = $contact->update($request->validated());

            return response()->json([
                'status' =>($contact ? true : false),
                'message' => 'Contato alterado com sucesso!',
                'data' => Contact::get()
            ]);

        }catch (\PDOException $e){
            return response()->json([
                'status' => false,
                'message' => 'falha ao executar a ação',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::whereId($id);

            if ($contact->doesntExist())
                return response()->json([
                    'status' => false,
                    'message' => 'O contato informado não existe.'
                ]);

            $delete = $contact->delete();

            if ($delete)
                return response()->json([
                    'status' => true,
                    'message' => 'Contato deletado com sucesso!',
                    'data' => Contact::get()
                ]);
        }catch (\PDOException $e){
            return response()->json([
                'status' => false,
                'message' => 'falha ao executar a ação',
                'error' => $e->getMessage()
            ]);
        }
    }

}