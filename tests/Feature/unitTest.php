<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class unitTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testGetListMember()
    {
    	$response = $this->call('GET', 'member');
        $response->assertStatus(200);
    }


    public function testDeleteMember(){
        $request = Factory(Member::class)->create([
            'name' => 'Root',
            'address' => 'TranDaiNghia',
            'age' => 21,
        ]);


        $response = $this->call('get','/delete/'.$request->id);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => 'Root',
                'address' => 'TranDaiNghia',
                'age' => 21,
            ]);
    }

    public function testDeleteMemberFails(){
        $request = Factory(Member::class)->create([
            'name' => 'Root',
            'address' => 'TranDaiNghia',
            'age' => 21,
        ]);
        $response = $this->call('get','/delete/'. 500);
        
        $this->assertEquals(500, $response->status());

    }
}
