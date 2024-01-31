<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Your Laravel App</title>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row">
                    <form method="POST" action="{{ route('multiTask') }}">
                        @csrf

                        <input type="hidden" name="id" value="{{ $recordId ?? '' }}">

                        <div id="dynamicFields">
                            @for ($i = 1; $i <= 4; $i++)
                                <div>
                                    <label for="field{{ $i }}" class="form-label">Field
                                        {{ $i }}:</label>
                                    <input type="text" class="form-control" name="fields[]"
                                        value="{{ $recordData['field' . $i] ?? '' }}">
                                </div>
                            @endfor
                        </div>

                        <button type="submit"
                            class="btn btn-primary mt-2">{{ isset($recordId) && $recordId ? 'Update' : 'Create' }}</button>

                    </form>
                </div>
                <div class="row">
                    @if (isset($existingRecords))
                        <h2>Existing Records</h2>
                        <table class="table table-primary">
                            <tr>
                                <th>ID</th>
                                @for ($i = 1; $i <= 4; $i++)
                                    <th>Field {{ $i }}</th>
                                @endfor
                                <th>Action</th>
                            </tr>
                            @foreach ($existingRecords as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <td>{{ $record['field' . $i] }}</td>
                                    @endfor
                                    <td>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $record->id }}">Edit</a>
                                           <!-- Delete -->
                                        <form method="POST" id="delete-form-{{$record->id}}" action="{{route('multiTask',$record->id)}}" style="display: none;">
                                            <input type="hidden" name="id" value="{{ $record->id }}">
                                            @csrf
                                            {{method_field('delete')}}
        
                                        </form>
                                        <button onclick="if(confirm('Are you sure, You want to delete this?')){
                                                                    event.preventDefault();
                                                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                                                    }else{
                                                                    event.preventDefault();
                                                                    }
                                                                    " class="btn" href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                            </svg>
                                        </button>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $record->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $record->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $record->id }}">
                                                            Modal title</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('multiTask') }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $record->id }}">
                                                            <div id="dynamicFields">
                                                                @for ($i = 1; $i <= 4; $i++)
                                                                    <div>
                                                                        <label for="field{{ $i }}" class="form-label">Field{{ $i }}:</label>
                                                                        <input type="text" class="form-control" name="fields[]" value="{{ $record['field' . $i] }}">
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary mt-2">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


</body>

</html>
