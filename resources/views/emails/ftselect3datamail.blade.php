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
  
            @foreach($ftdataobj['graph'] as $key =>$item)
            <p>
                        <img src="{{ url('/') }}/ft_form/{{ $item }}" alt="">
                        
                        <h3>{!! $ftdataobj['result'][$key]['txt'] !!}</h3>
                        <h3>ปัญหาที่พบ : 
                        @if (!empty($ftdataobj['result'][$key]['problem']))                            
                           @foreach ($ftdataobj['result'][$key]['problem'] as $problem)
                               {{ $problem }} <br/>  
                           @endforeach 
                        @else
                            ไม่พบปัญหา
                        @endif
                        </h3>
                        @if (!empty($ftdataobj['result'][$key]['problem_img']))                            
                           @foreach ($ftdataobj['result'][$key]['problem_img'] as $problemimg)
                               <a href="{{ url('/') }}/ft_form/{{ $problemimg }}" target="_blank">{{ HTML::image('/ft_form/'.$problemimg, 'alt', array( 'height' => 200 )) }}</a>                                
                            @endforeach 
                        @endif
 <br/></p>
            @endforeach

                        @foreach($ftdataobj['graph2'] as $item)
            <p>
                            <img src="{{ url('/') }}/ft_form/{{ $item }}" alt="">
            
 <br/></p>
            @endforeach
    
</body>
</html>