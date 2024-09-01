<div>
    <div>
        <div class="flex-1 w-full py-2 px-2 grid gap-6 mb-6 bg-gray-300 sm:border-r rounded">
            <div class="py-1 px-1 text-gray-800">
                Agendar serviço para  <span class="text-gray-600"><strong>{{ strtoupper($customer->name) }}</strong> </span>
            </div>
            @foreach($customer->vehicle as $vehicle)
                {{ $vehicle }}
            @endforeach
        </div>
    </div>
</div>
