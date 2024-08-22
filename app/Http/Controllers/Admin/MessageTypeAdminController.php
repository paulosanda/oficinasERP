<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageType;
use App\Trait\RemoveNullElementsFromArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageTypeAdminController extends Controller
{
    use RemoveNullElementsFromArray;

    /**
     * @OA\Get(
     *      path="/api/admin/messages",
     *      operationId="messagesIndex",
     *      tags={"Admin"},
     *      summary="MessagesList",
     *      description="lista de tipos de mensagens para serem enviadas aos clientes em serviços agendados",
     *      security={{ "bearerAuth" : {} }},

     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/MessageType" )
     *          )
     *      ),
     *
     *      @OA\Response(
     *      response=403,
     *      description="Não autorizado",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *       )
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $messageType = MessageType::all()->toArray();

        return response()->json($messageType);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/messages",
     *     operationId="messageStore",
     *     tags={"Admin"},
     *     summary="newMessage",
     *     description="criar nova message",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         request="dadosNewMessage",
     *         description="dados para criar uma nova mensagem",
     *
     *         @OA\JsonContent(ref="#/components/schemas/MessageType")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="success")
     *         )
     *     ),
     *
     *     @OA\Response(
     *       response=403,
     *       description="Não autorizado",
     *
     *       @OA\JsonContent(
     *
     *           @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *        )
     *      ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'schedulable_service_id' => 'integer|required',
            'model_name' => 'required|string',
            'title' => 'required|string',
            'message' => 'string',
        ];

        $messages = [
            'schedulable_service_id.integer' => 'O ID do serviço agendável deve ser um número inteiro.',
            'schedulable_service_id.required' => 'O ID do serviço agendável é obrigatório.',
            'model_name.required' => 'O nome do modelo é obrigatório.',
            'model_name.string' => 'O nome do modelo deve ser um texto.',
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'message.string' => 'A mensagem deve ser um texto.',
        ];

        $data = $request->validate($rules, $messages);

        MessageType::create($data);

        return response()->json(['message' => 'success']);
    }

    //todo fazer documentação
    public function update($messageTypeId, Request $request): JsonResponse
    {
        $rules = [
            'schedulable_service_id' => 'integer|required',
            'model_name' => 'string|nullable',
            'title' => 'string|nullable',
            'message' => 'string|nullable',
        ];

        $data = $request->validate($rules);
        $data = $this->removeNull($data);

        $updateMessageType = MessageType::find($messageTypeId);
        $updateMessageType->update($data);

        return response()->json(['message' => 'success']);

    }
}
