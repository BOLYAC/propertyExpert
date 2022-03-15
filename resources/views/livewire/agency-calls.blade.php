<div>
    {{ $agency->phone ?? '' }}
    <a href="https://wa.me/{{$agency->phone}}" target="_blank"
       class="btn btn-xs btn-outline-success float-right mr-2"><i
            class="fa fa-whatsapp"></i></a>
    <a href="javascript:void(0)"
       class="btn btn-xs btn-outline-primary float-right"
       wire:click="makeCall()"><i
            class="fa fa-phone"></i></a>
</div>
