<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseAction
{
    public function validate(Request $request): bool
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    abstract protected function rules(): array;
}

