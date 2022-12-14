<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Models\TariffText;
use App\Models\Translate;
use Illuminate\Http\Request;
use function redirect;
use function request;
use function view;

/**
 * Class TariffController
 * @package App\Http\Controllers
 */
class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tariffs = Tariff::get();

        return view('admin.tariff.index', compact('tariffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tariff = new Tariff();
        return view('admin.tariff.create', compact('tariff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = Translate::create([
            'ru'    =>  $request->title_ru,
            'kz'    =>  $request->title_kz,
            'en'    =>  $request->title_en,
        ]);
        $description = Translate::create([
            'ru'    =>  $request->description_ru,
            'kz'    =>  $request->description_kz,
            'en'    =>  $request->description_en,
        ]);
        $courseText = Translate::create([
            'ru'    =>  $request->course_text_ru,
            'kz'    =>  $request->course_text_kz,
            'en'    =>  $request->course_text_en,
        ]);

        $tariff = Tariff::create([
            'title' =>  $title['id'],
            'description'   =>  $description['id'],
            'price' =>  $request['price'],
            'old_price' =>  $request['old_price'],
            'course_text'   =>  $courseText->id,
        ]);

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tariff = Tariff::find($id);
        $texts = TariffText::where('tariff_id', $id)->get();

        return view('admin.tariff.show', compact('tariff', 'texts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tariff = Tariff::find($id);

        return view('admin.tariff.edit', compact('tariff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tariff $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        Translate::find($tariff->title)->update([
            'ru'    =>  $request->title_ru,
            'kz'    =>  $request->title_kz,
            'en'    =>  $request->title_en,
        ]);
        Translate::find($tariff->description)->update([
            'ru'    =>  $request->description_ru,
            'kz'    =>  $request->description_kz,
            'en'    =>  $request->description_en,
        ]);
        Translate::find($tariff->discount_text)->update([
            'ru'    =>  $request->discount_ru,
            'kz'    =>  $request->discount_kz,
            'en'    =>  $request->discount_en,
        ]);
        if (isset($tariff->course_text)) {
            Translate::find($tariff->course_text)->update([
                'ru' => $request->course_text_ru,
                'kz' => $request->course_text_kz,
                'en' => $request->course_text_en,
            ]);
        } else {
            $courseText = Translate::create([
                'ru'    =>  $request->course_text_ru,
                'kz'    =>  $request->course_text_kz,
                'en'    =>  $request->course_text_en,
            ]);
        }

        $tariff->update([
            'price' =>  $request['price'],
            'count' =>  $request['count'] ?? $tariff['count'],
            'discount'  =>  $request['discount'],
            'old_price' =>  $request['old_price'],
            'course_text'   =>  isset($courseText) ? $courseText->id : $tariff->course_text,
        ]);

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tariff = Tariff::find($id)->delete();

        return redirect()->route('tariffs.index')
            ->with('success', 'Tariff deleted successfully');
    }
}
