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
  
            @foreach($predataobj['graph'] as $key => $item)
            <p>
                        <img src="{{ url('/') }}/ft_form/{{ $item }}" alt="">
                        <br/>
                        <h3>{!! $predataobj['result'][$key]['txt'] !!}</h3>
                        <br/><h3>ปัญหาที่พบ : 
                        @if (!empty($predataobj['result'][$key]['problem']))                            
                           @foreach ($predataobj['result'][$key]['problem'] as $problem)
                               {{ $problem }} , 
                           @endforeach 
                        @else
                            ไม่พบปัญหา
                        @endif
                        </h3>
 <br/></p>
            @endforeach
    
</body>
</html>