<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FT Form Alert</title>
    <style>
        table {
            border: solid 2px black;
        }
        thead tr th{
            border: solid 1px black;
            font-weight: bold;
            font-style: italic;
        }
        tbody tr td{
            border: solid 1px black;
        }
    </style>
</head>
<body>
    <p><strong>TO..ALL</strong></p>
    <p><strong>FT Form Alert System</strong></p>
  
            @foreach($packdataobj['graph'] as $key1 => $item2)
            @foreach($item2 as $key2 => $item1)
            @foreach($item1 as $key3 => $item)
            <p>
                        <img src="{{ url('/') }}/ft_form/{{ $item }}" alt="">
                        <h3>{!! $packdataobj['result'][$key1][$key2][$key3]['txt'] !!}</h3>
                        <h3>ปัญหาที่พบ : 
                        @if (!empty($packdataobj['result'][$key1][$key2][$key3]['problem']))                            
                           @foreach ($packdataobj['result'][$key1][$key2][$key3]['problem'] as $problem)
                               {{ $problem }} <br/> 
                           @endforeach 
                        @else
                            ไม่พบปัญหา
                        @endif
                        </h3>
                       @if (!empty($packdataobj['result'][$key1][$key2][$key3]['problem_img']))                            
                           @foreach ($packdataobj['result'][$key1][$key2][$key3]['problem_img'] as $problemimg)
                               <a href="{{ url('/') }}/ft_form/{{ $problemimg }}" target="_blank">{{ HTML::image('/ft_form/'.$problemimg, 'alt', array( 'height' => 200 )) }}</a>                                
                            @endforeach 
                        @endif
 <br/></p>
 @endforeach
            @endforeach
            @endforeach
    
</body>
</html>