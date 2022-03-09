<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CardController extends Controller
{
    /**
     * Generate and display id card.
     */
    public function __invoke($id)
    {
        if (Auth::user()->name !== 'ICT') {
            abort(403);
        }
        
        $employee = Employee::find($id);
        
        if ($employee === null) {
            abort(404);
        }
        
        if ($employee->active_from && $employee->active_to === null) {
            $this->generateRegularID($employee);
        } else {
            $this->generateJCID($employee);
        }
        
        return view('card')->with('employee', $employee);
    }
    
    /**
     * Generate ID cards for permanent employees.
     *
     * @param $employee
     */
    private function generateRegularID($employee)
    {
        $template_front = Image::make(Storage::get('public/templates/reg_front.png'));
    
        $avatar_reshape = Image::canvas(400, 400);
        $avatar_reshape->circle(400, 200, 200, function ($draw) {
            $draw->background('#ffffff');
        });
    
        $avatar = Image::make(Storage::get('public/photos/'.($employee->photo ?? 'placeholder.png')));
        $avatar->resize(399, 399);
        $avatar->mask($avatar_reshape->encode('png'), true);
    
        $template_front->insert($avatar->encode(), 'center', -481, 111);
    
        $employee_name = $employee->given_name.' '
            .$employee->middle_name.' '
            .$employee->family_name.' '
            .$employee->name_suffix;
    
        $template_front->text(strtoupper(trim($employee_name)), 1000, 500, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Bold.otf'));
            $font->size(80 - strlen($employee_name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(wordwrap(strtoupper($employee->position), 50), 1000, 550, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee->code), 280, 850, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(40);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee->address), 680, 700, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(32);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee->contact_number), 680, 770, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(32);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee->email ?? ''), 680, 850, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(32);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('center');
        });
    
        $template_back = Image::make(Storage::get('public/templates/reg_back.png'));
    
        $template_back->text(strtoupper($employee->birth_date ?? ''), 700, 88, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->sex ?? ''), 700, 168, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->blood_type ?? ''), 700, 248, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->gsis_number ?? ''), 700, 358, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->pagibig_number ?? ''), 700, 438, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->philhealth_number ?? ''), 700, 518, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->tin_number ?? ''), 700, 598, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->emergency_contact ?? ''), 700, 783, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $template_back->text(strtoupper($employee->emergency_contact_number ?? ''), 700, 863, function ($font) {
            $font->file(public_path('fonts/Matter/Matter-Regular.otf'));
            $font->size(28);
            $font->color('#0b3f29');
            $font->align('right');
            $font->valign('center');
        });
    
        $qrcode = Image::make(base64_encode(QrCode::format('png')
            ->size(265)
            ->color(11, 63, 41)
            ->margin(1)
            ->encoding('UTF-8')
            ->merge('/public/logos/doh.png')
            ->generate('http://192.168.224.69:3000/api/verify/'.Crypt::encryptString($employee->code))
        ));
    
        $qr_border = Image::canvas(280, 280, '#0b3f29');
        
        $template_back->insert($qr_border->encode(), 'center', 355, 80);
        $template_back->insert($qrcode->encode(), 'center', 355, 80);
    
        Storage::put('public/cards/front_'.($employee->photo ?? 'placeholder.png'), (string) $template_front->encode());
        Storage::put('public/cards/back_'.($employee->photo ?? 'placeholder.png'), (string) $template_back->encode());
    }
    
    /**
     * Generate ID cards for job contractors.
     *
     * @param $employee
     */
    private function generateJCID($employee)
    {
        $template_front = Image::make(Storage::get('public/templates/jc_front.png'));
    
        $avatar = Image::make(Storage::get('public/photos/'.($employee->photo ?? 'placeholder.png')));
        $avatar->resize(796, 729);
        
        $template_front->insert($avatar->encode(), 'center', -180, -220);
    
        $template_front_2 = Image::make(Storage::get('public/templates/jc_front_2.png'));
        $template_front->insert($template_front_2->encode(), 'center', 0, 00);
    
        // nickname
        $nickname = $employee->nickname ?? explode(' ', $employee->given_name)[0];
    
        $template_front->text(strtoupper($nickname), 940, 607, function ($font) use ($nickname) {
            $font->file(public_path('fonts/Matter/Matter-HeavyItalic.otf'));
            $font->size(100 - strlen($nickname));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_front->text(strtoupper($nickname), 940, 600, function ($font) use ($nickname) {
            $font->file(public_path('fonts/Matter/Matter-HeavyItalic.otf'));
            $font->size(100 - strlen($nickname));
            $font->color('#80c892');
            $font->align('center');
            $font->valign('center');
        });
    
        // name
        $employee_name = $employee->given_name.' '
            .$employee->middle_name.' '
            .$employee->family_name.' '
            .$employee->name_suffix;
    
        $template_front->text(strtoupper($employee_name), 625, 1139, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee_name), 625, 1141, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee_name), 624, 1140, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee_name), 626, 1140, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee_name), 625, 1147, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#008e4d');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text(strtoupper($employee_name), 625, 1140, function ($font) use ($employee_name) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(110 - strlen($employee_name));
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
    
        // position
        $template_front->text($employee->position, 625, 1219, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text($employee->position, 625, 1221, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text($employee->position, 624, 1220, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text($employee->position, 626, 1224, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#0b3f29');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text($employee->position, 625, 1220, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#008e4d');
            $font->align('center');
            $font->valign('center');
        });
    
        $template_front->text($employee->position, 625, 1220, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Medium.otf'));
            $font->size(55 - strlen($employee->position));
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
    
        // id number
        $template_front->text(strtoupper($employee->code ?? ''), 625, 1705, function ($font) use ($employee) {
            $font->file(public_path('fonts/Matter/Matter-Heavy.otf'));
            $font->size(60 - strlen($employee->code));
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('center');
        });
        
        $template_back = Image::make(Storage::get('public/templates/jc_back.png'));
        
        $qrcode = Image::make(base64_encode(QrCode::format('png')
            ->size(250)
            ->color(41, 142, 103)
            ->margin(1)
            ->encoding('UTF-8')
            ->merge('/public/logos/doh.png')
            ->generate('http://192.168.224.69:3000/api/verify/'.Crypt::encryptString($employee->code))
        ));
        
        $qr_border = Image::canvas(260, 260, '#298e67');
        
        $template_back->insert($qr_border->encode('png'), 'center', 395, 682);
        $template_back->insert($qrcode->encode(), 'center', 395, 682);
        
        Storage::put('public/cards/front_'.($employee->photo ?? 'placeholder.png'), (string) $template_front->encode());
        Storage::put('public/cards/back_'.($employee->photo ?? 'placeholder.png'), (string) $template_back->encode());
    }
}
