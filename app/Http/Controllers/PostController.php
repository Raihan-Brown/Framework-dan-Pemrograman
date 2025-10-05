<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /posts
    public function index()
    {
        return "Ini halaman daftar post (INDEX)";
    }

    // GET /posts/create
    public function create()
    {
        return "Form tambah post (CREATE)";
    }

    // POST /posts
    public function store(Request $request)
    {
        return "Proses simpan post baru (STORE)";
    }

    // GET /posts/{id}
    public function show($id)
    {
        return "Tampilkan detail post dengan ID: $id (SHOW)";
    }

    // GET /posts/{id}/edit
    public function edit($id)
    {
        return "Form edit post dengan ID: $id (EDIT)";
    }

    // PUT/PATCH /posts/{id}
    public function update(Request $request, $id)
    {
        return "Proses update post dengan ID: $id (UPDATE)";
    }

    // DELETE /posts/{id}
    public function destroy($id)
    {
        return "Proses hapus post dengan ID: $id (DESTROY)";
    }
}


// class PostController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }

