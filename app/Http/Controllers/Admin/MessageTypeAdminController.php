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
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          description="token de acesso do usuário admin",
     *          @OA\Schema(type="string", format="Bearer {token}")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/MessageType" )
     *          )
     *      ),
     *      @OA\Response(
     *      response=403,
     *      description="Não autorizado",
     *      @OA\JsonContent(
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
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="token de acesso do usuário admin",
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *     @OA\RequestBody(
     *         request="dadosNewMessage",
     *         description="dados para criar uma nova mensagem",
     *         @OA\JsonContent(ref="#/components/schemas/MessageType")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *       response=403,
     *       description="Não autorizado",
     *       @OA\JsonContent(
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
            'message' => 'string'
        ];

        $data = $request->validate($rules);

       MessageType::create($data);

        return  response()->json(['message' => 'success']);
    }

    public function update($messageTypeId, Request $request): JsonResponse
    {
        $rules = [
            'schedulable_service_id' => 'integer|required',
            'model_name' => 'string|nullable',
            'title' => 'string|nullable',
            'message' => 'string|nullable'
        ];

        $data = $request->validate($rules);
        $data = $this->removeNull($data);

        $updateMessageType = MessageType::find($messageTypeId);
        $updateMessageType->update($data);

        return response()->json(['message' => 'success']);

    }
}
