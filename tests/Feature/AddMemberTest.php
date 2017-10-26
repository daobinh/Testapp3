<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddMemberTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddMemberSuccess()
    {
        $request = [
            'name' => 'RomeCody',
            'address' => 'NamTuLiem,HaNoi',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);
        if($response->status() == 302){
            print_r($response->exception->validator->messages()->messages());
        }
        else{
            $this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseHas('members',
            [
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
    }

    public function testAddMemberSuccessHasPhoto()
    {
        copy('photo\images.jpg','public\photo\images.jpg');   
        $photo = new UploadedFile(base_path('public\photo\images.jpg'),
            'images.jpg', 'image/jpg', 111, $error = null, $test = true);
        $request = [
            'name' => 'hoa',
            'address' => 'ha noi',
            'age' => 23,
            'photo' => $photo
        ];
       $response = $this->call('POST', '/member', $request);
       $this->assertEquals(200, $response->status());
       $this->assertDatabaseHas('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);
       
    }

    public function testAddNameNull(){
        $request = [
            'name' => '',
            'address' => 'HN',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);
        if ($response->status() == 302) 
        {
            print_r($response->exception->validator->messages()->messages());
        }
        else
        {
            $this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);

    }

    

    public function testAddNameAlphaCharacter()
    {
        $request = [
            'name' => 'binh123',
            'address' => 'thanh hoa',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);
        if ($response->status() == 302) 
        {
            print_r($response->exception->validator->messages()->messages());
        }
        else
        {
            $this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);

    }

    public function testAddName100Charaters()
    {
        $request = [
            'name' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabca',
            'address' => 'HN',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
    }

    public function testAddNamemorethan100Charaters(){
        $request = [
            'name' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcab',
            'address' => 'HN',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);

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
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
        
    }


    public function testAddAddressEqual300Charaters()
    {
        $request = [
            'name' => 'binh',
            'address' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabca',
            'age' => 23,
        ];

        $response = $this->call('POST', '/member', $request);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
    }

    public function testAddAddressNull()
    {
        $request = [
            'name' => 'binh',
            'address' => '',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);
        if ($response->status() == 302) 
        {
            print_r($response->exception->validator->messages()->messages());
        }
        else
        {
            $this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);

    }

    public function testAddAddressmorethan300Characters(){
        $request = [
            'name' => 'binh',
            'address' => 'abcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaabcabcabcaa',
            'age' => 23,
        ];
        $response = $this->call('POST', '/member', $request);

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
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
        
    }

    public function testAddAgeNull()
    {
        $request = [
            'name' => 'binh',
            'address' => 'ThanhHoa',
            'age' => '',
        ];
        $response = $this->call('POST', '/member', $request);
        if ($response->status() == 302) 
        {
            print_r($response->exception->validator->messages()->messages());
        }
        else
        {
            $this->assertEquals(200, $response->status());
        }
        
        $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);

    }

    public function testAddAgeNumeric(){
        $request = [
            'name' => 'binh',
            'address' => 'ThanhHoa',
            'age' => 'ab',
        ];
        $response = $this->call('POST', '/member', $request);

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
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
        
    }

    public function testAddAgeMax2Character(){
        $request = [
            'name' => 'binh',
            'address' => 'ThanhHoa',
            'age' => 123,
        ];
        $response = $this->call('POST', '/member', $request);

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
                'name' => $request['name'],
                'address' => $request['address'],
                'age' => $request['age'],
            ]);
        
    }
    public function testAddPhotoNotImage(){
        copy('photo\test.png','public\photo\test.png');   
        $photo = new UploadedFile(base_path('public\photo\test.png'),
            'test.png', 'image/png', 111, $error = null, $test = true);
        $request = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 23,
            'photo' => $photo
        ];
       $response = $this->call('POST', '/member', $request);
       if ($response->status() == 302) 
       {
           print_r($response->exception->validator->messages()->messages());
       }
       else
       {
        $this->assertEquals(200, $response->status());
       }
       
       $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);
    }

    public function testAddPhotoTypebmp(){
        copy('photo\anhtest.bmp','public\photo\anhtest.bmp');   
        $photo = new UploadedFile(base_path('public\photo\anhtest.bmp'),
            'anhtest.bmp', 'anhtest.bmp', 111, $error = null, $test = true);
        $request = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 23,
            'photo' => $photo
        ];
       $response = $this->call('POST', '/member', $request);
       if ($response->status() == 302) 
       {
           print_r($response->exception->validator->messages()->messages());
       }
       else
       {
        $this->assertEquals(200, $response->status());
       }
       
       $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);
    }

    // public function testAddPhotoLessthan10MB(){
    //     copy('photo\images.jpg','public\photo\images.jpg');   
    //     $photo = new UploadedFile(base_path('public\photo\images.jpg'),
    //         'images.jpg', 'image/jpg', 111, $error = null, $test = true);
    //     $request = [
    //         'name' => 'binh',
    //         'address' => 'thanh hoa',
    //         'age' => 23,
    //         'photo' => $photo
    //     ];
    //    $response = $this->call('POST', '/member', $request);
    //    // dd($response->status());
    //    $this->assertEquals(200, $response->status());
    //    $this->assertDatabaseMissing('members', [
    //         'name' => $request['name'],
    //         'address' => $request['address'],
    //         'age' => $request['age'],
    //         'photo' => $request['photo']
    //     ]);
    // }

    public function testAddPhotoMax10MB(){
        copy('photo\image10MB.jpg','public\photo\image10MB.jpg');   
        $photo = new UploadedFile(base_path('public\photo\image10MB.jpg'),
            'image10MB.jpg', 'image10MB.jpg', 10480, $error = null, $test = true);
        $request = [
            'name' => 'binh',
            'address' => 'thanh hoa',
            'age' => 23,
            'photo' => $photo
        ];
       $response = $this->call('POST', '/member', $request);
       if ($response->status() == 302) 
       {
           print_r($response->exception->validator->messages()->messages());
       }
       else
       {
        $this->assertEquals(200, $response->status());
       }
       
       $this->assertDatabaseMissing('members', [
            'name' => $request['name'],
            'address' => $request['address'],
            'age' => $request['age'],
        ]);
    }

}
