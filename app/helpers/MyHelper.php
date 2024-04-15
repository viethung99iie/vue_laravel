<?php

if(!function_exists('loadClass')){
    function loadClass($model, $folder = 'Repositories', $interface = 'Repository'){

        $serviceInterfaceNamespace = '\App\\'.$folder.'\\' . ucfirst($model) . $interface;
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        return $serviceInstance;
    }
}



if(!function_exists('convertDateFormat')){
    function convertDateFormat($inputTime, $inputFormat = 'd-m-Y', $outputFormat = 'Y-m-d H:i:s'){

        $carbonDate =  Illuminate\Support\Carbon::createFromFormat($inputFormat, $inputTime);
        $newFormat = $carbonDate->format($outputFormat);
        return $newFormat;
    }
}



if(!function_exists('castRequest')){
    function castRequest($payload, $keyArray = []){
        foreach($keyArray as $key => $val){
            $snakeKey = Illuminate\Support\Str::snake($val);
            $payload[$snakeKey] = $payload[$val];
            unset($payload[$val]);
        }
        return $payload;

    }
}
