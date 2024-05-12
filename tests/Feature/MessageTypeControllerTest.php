<?php

namespace Tests\Feature;

use App\Models\MessageType;
use App\Models\SchedulableService;
use App\Models\User;
use Database\Seeders\SchedulableServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MessageTypeControllerTest extends TestCase
{
   use RefreshDatabase;

   private User $user;

   public function setUp(): void
   {
       parent::setUp();

       Artisan::call('db:seed', [SchedulableServiceSeeder::class]);

       $models = [
           ['model_name' =>'troca_de_oleo', 'schedulable_service_id' => 1],
           ['model_name' => 'alinhamento',  'schedulable_service_id' => 2],
           ['model_name' => 'correia_dentada', 'schedulable_service_id' => 3]
       ];

       foreach($models as $model) {

           MessageType::create([
               'schedulable_service_id' => $model['schedulable_service_id'],
               'model_name' => $model['model_name']
               ]);
       }

       $this->user =  User::factory()->create();
   }

   public function testIndex(): void
   {
       $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->getJson(route('message.index'));

       $response->assertStatus(200);

       $response->assertJsonStructure([
           ['id',
           'schedulable_service_id',
           'model_name',
           'title',
           'message']
       ]);
   }

   public function testStoreCompletePayload(): void
   {
       $newMessage = [
           'schedulable_service_id' => 4,
           'model_name' => 'new_model',
           'title' => fake()->title,
           'message' => fake()->text
       ];

       $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->postJson(route('message.store'), $newMessage);

       $response->assertStatus(200);

       $response->assertJson(['message' => 'success']);

       $this->assertDatabaseHas('message_types', [
           'model_name' => $newMessage['model_name']
       ]);
   }

   public function testStoreWithoutMessageFieldReturnSucess(): void
   {
       $newMessage = [
           'schedulable_service_id' => 4,
           'model_name' => 'new_model',
           'title' => fake()->title,
       ];

       $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->postJson(route('message.store'), $newMessage);

       $response->assertStatus(200);

       $response->assertJson(['message' => 'success']);

       $this->assertDatabaseHas('message_types', [
           'model_name' => $newMessage['model_name']
       ]);
   }

   public function testStoreWithoutModelFieldError(): void
   {
       $newMessage = [
           'schedulable_service_id' => 4,
           'model_name' => null,
           'title' => fake()->title,
           'message' => fake()->text
       ];

       $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->postJson(route('message.store'), $newMessage);

       $response->assertStatus(422);

       $response->assertJson([
           'message' => 'validation.required',
           'errors' => [
               'model_name' => [
                   'validation.required'
               ]
           ]
       ]);

       $this->assertDatabaseMissing('message_types', [
           'model_name' => $newMessage['model_name']
       ]);
   }

   public function testUpdate(): void
   {
       $message = MessageType::first();
       $message->update(['model_name' => 'updated']);

       $messageUpdate = $message->toArray();

       $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->putJson(route('message.update', $messageUpdate['id']), $messageUpdate );

       $response->assertStatus(200);

       $response->assertJson(['message' => 'success']);

       $this->assertDatabaseHas('message_types' , [
           'model_name' => 'updated'
       ]);
   }
}
