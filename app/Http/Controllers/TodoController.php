<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo_token = 'Bearer ' . Session::get('todo_token');

        $client = new Client();
        $response = $client->get('https://todo-api-kahh.onrender.com/api/v1/todos', [
            'headers' => [
                'Authorization' => $todo_token,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            return abort($response->getStatusCode());
        }


        $todo = json_decode($response->getBody());
        // dd($todo);

        return view('todos.index', compact('todo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $todo_token = Session::get('todo_token');

        $client = new Client();

        $response = $client->request('POST', 'https://todo-api-kahh.onrender.com/api/v1/todos/', [
            'headers' => [
                'Authorization' => 'Bearer ' . $todo_token,
            ],
            'json' => [
                "name" => $request->name
            ]
        ]);

        if ($response->getStatusCode() != 201) {
            return abort($response->getStatusCode());
        }


        return redirect('/todos')->withMessage("Successfully Created");
    }

    /**
     * Display the specified resource.
     *
     * @param    $todo
     * @return \Illuminate\Http\Response
     */
    public function show($todo)
    {
        $todo_token = Session::get('todo_token');

        $client = new Client();
        $url = 'https://todo-api-kahh.onrender.com/api/v1/todos/' . $todo;
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $todo_token,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            return abort($response->getStatusCode());
        }

        $data = json_decode($response->getBody());
        $todo = $data->data;
        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo_token = Session::get('todo_token');

        $client = new Client();

        $url = 'https://todo-api-kahh.onrender.com/api/v1/todos/' . $id;

        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $todo_token,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            return abort($response->getStatusCode());
        }

        $data = json_decode($response->getBody());
        $todo = $data->data;
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param    $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $todo_token = Session::get('todo_token');

        $client = new Client();
        $url = 'https://todo-api-kahh.onrender.com/api/v1/todos/' . $request->id;


        $response = $client->request('PUT', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $todo_token,
            ],
            'json' => [
                "name" => $request->name
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return abort($response->getStatusCode());
        }

        $todo = json_decode($response->getBody());


        return redirect('/todos')->withMessage("Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo_token = Session::get('todo_token');

        $client = new Client();
        $url = 'https://todo-api-kahh.onrender.com/api/v1/todos/' . $id;

        $response = $client->request('DELETE', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $todo_token,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            return abort($response->getStatusCode());
        }

        $todo = json_decode($response->getBody());

        return redirect('/todos')->withMessage("Successfully Deleted!");
    }
}
