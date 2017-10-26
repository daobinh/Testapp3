<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class EditMemberTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testEdit(){

    	$response = $this->get(route('member.edit', ['id' => 2]));
        $response->assertStatus(200);
    }

    public function testEditMemberSuccess()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditMemberSuccessHasPhoto()
    {
    	copy('photo\images.jpg','public\photo\images.jpg');   
        $photo = new UploadedFile(base_path('public\photo\images.jpg'),
            'images.jpg', 'image/jpg', 111, $error = null, $test = true);

        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'photo' => $photo
        ]);
        $editMember = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 21,
            'photo' => $photo
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
    }

    public function testEditNameNull()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => '',
            'address' => 'thanh hoa',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditNameAlphaCharacter()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'ababa12',
            'address' => 'thanh hoa',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditNameMorethan100Character()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcab',
            'address' => 'thanh hoa',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditAddressNull()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'Binh',
            'address' => '',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditAddressMorethan300Character()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'Binh',
            'address' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaa',
            'age' => 21,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditAgeNull()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'Binh',
            'address' => 'Thanh Hoa',
            'age' => '',
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditAgeNumeric()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'Binh',
            'address' => 'Thanh Hoa',
            'age' => 'ab',
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditAgeMax2Character()
    {
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ]);
        $editMember = [
            'name' => 'Binh',
            'address' => 'Thanh Hoa',
            'age' => 212,
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
        	print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members',
            [
                'name' => $editMember['name'],
                'address' => $editMember['address'],
                'age' => $editMember['age'],
            ]);
       
    }

    public function testEditPhotoNotImage(){
        copy('photo\test.png','public\photo\test.png');   
        $photo = new UploadedFile(base_path('public\photo\test.png'),
            'test.png', 'image/png', 111, $error = null, $test = true);
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'photo' => $photo
        ]);
        $editMember = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 21,
            'photo' => $photo
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
        if ($response->status() == 302) 
        {
           print_r($response->exception->validator->messages()->messages());
        }
        else
        {
        	$this->assertEquals(200, $response->status());
       	}
       
       	$this->assertDatabaseMissing('members', [
            'name' => $editMember['name'],
            'address' => $editMember['address'],
            'age' => $editMember['age'],
        ]);
    }

    public function testEditPhotoTypebmp(){
        copy('photo\anhtest.bmp','public\photo\anhtest.bmp');   
        $photo = new UploadedFile(base_path('public\photo\anhtest.bmp'),
            'anhtest.bmp', 'anhtest.bmp', 111, $error = null, $test = true);
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'photo' => $photo
        ]);
        $editMember = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 21,
            'photo' => $photo
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
       	if ($response->status() == 302) 
       	{
           print_r($response->exception->validator->messages()->messages());
       	}
       	else
       	{
        	$this->assertEquals(200, $response->status());
       	}
       
       	$this->assertDatabaseMissing('members', [
            'name' => $editMember['name'],
            'address' => $editMember['address'],
            'age' => $editMember['age'],
        ]);
    }

    public function testEditPhotoMax10MB(){
        copy('photo\image10MB.jpg','public\photo\image10MB.jpg');   
        $photo = new UploadedFile(base_path('public\photo\image10MB.jpg'),
            'image10MB.jpg', 'image10MB.jpg', 10480, $error = null, $test = true);
        $request = Factory(Member::class)->create([
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
            'photo' => $photo
        ]);
        $editMember = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 21,
            'photo' => $photo
        ];

        $response = $this->call('POST',
            route('member.update', ['id' => $request->id]), $editMember);
       	if ($response->status() == 302) 
       	{
           print_r($response->exception->validator->messages()->messages());
       	}
       	else
       	{
        	$this->assertEquals(200, $response->status());
       	}
       
       	$this->assertDatabaseMissing('members', [
            'name' => $editMember['name'],
            'address' => $editMember['address'],
            'age' => $editMember['age'],
        ]);
    }

    
}
