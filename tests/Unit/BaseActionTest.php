<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Actions\BaseAction;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class BaseActionTest extends TestCase
{
    public function testeValidatesRequestCorrectly()
    {
        $mockAction = new MockAction();
        $request = new Request(['field' => 'value']);

        $validatorMock = $this->getMockBuilder('Illuminate\Validation\Validator')
            ->disableOriginalConstructor()
            ->getMock();
        $validatorMock->method('fails')->willReturn(false);

        Validator::shouldReceive('make')->andReturn($validatorMock);

        $isValid = $mockAction->validate($request);

        $this->assertTrue($isValid);
    }
}

class MockAction extends BaseAction
{
    protected function rules(): array
    {
        return [
            'field' => 'required|string',
        ];
    }
}
