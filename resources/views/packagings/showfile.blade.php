<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Packagings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"><h3>{{ $package->name }}</h3>
                        <h4>{{ $package->desc }}</h4>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        
                        <div class="table-responsive">
                            <table class="table">
                                 <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Files</th>
                                        <th>Donwload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (!empty($files))
                                    
                                

                                @foreach($files as $key=>$item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item }}</td>
                                        <td>
                                            <a href="{{ url('/packagings/downloadfile/'.$id.'/' . $key ) }}" title="Edit Packaging"><button class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download</button></a>

                                        </td>
                                    </tr>
                                @endforeach
                                
                                @else
                                    <tr>
                                        <td colspan="3"> ไม่มีข้อมูล หรือ กำหนด Path ผิด </td>    
                                    </tr>    
                                @endif
                                </tbody>
                            </table>
                        </div>

            </div>
        </div>
    </div>
</x-app-layout>