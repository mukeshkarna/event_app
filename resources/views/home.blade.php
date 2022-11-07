@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Events
                            <div class="row">
                                <div class="col-md-8">
                                    <form>
                                        <select class="form-select" name="filter_status" onchange="this.form.submit()">
                                            <option value="">Please Select</option>
                                            <option value="1" @if ($status == '1') selected @endif>
                                                Upcoming events
                                            </option>
                                            <option value="2" @if ($status == '2') selected @endif>
                                                Finished events
                                            </option>
                                            <option value="3" @if ($status == '3') selected @endif>
                                                Upcoming events within 7 days
                                            </option>
                                            <option value="4" @if ($status == '4') selected @endif>
                                                Finished events of the last 7 days
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('events.create') }}" class="btn btn-success btn-sm">Create</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">S.N.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($events as $event)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>{{ $event->start_date }}</td>
                                        <td>{{ $event->end_date }}</td>
                                        <td>
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm delete-event"
                                                data-id="{{ $event->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No records Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex">
                            {!! $events->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });
        $(document).on("click", ".delete-event", function() {
            var eventId = $(this).data("id");

            swal({
                title: "Are you sure?",
                text: "The item will be removed",
                buttons: ["No, cancel it!", "Yes, I am sure!"],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: `/events/${eventId}`,
                        success: function(result) {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        },
                    });
                }
            });
        });
    </script>
@endsection
