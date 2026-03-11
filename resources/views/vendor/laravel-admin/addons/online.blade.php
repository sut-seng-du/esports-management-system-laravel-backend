<style>
    .upper{
        padding: 10px;
    }
    .upper-block{
        background: #ffffff;
        border-radius: 20px;
        box-shadow: rgba(0, 0, 0, 0.35) 5px 5px 15px;
    }
    .block {
        display: block; /* Changed from flex to block for easier image centering */
        height: 100px;
        text-align: center;
    }
    .img-computer {
        margin: 0 auto;
        display: block;
        max-height: 80px;
        border: none !important;
        box-shadow: none !important;
        border-radius: 10px;
    }
    .bg-success {
        background: #00ff00 !important;
        color: #040000 !important;
    }
    .bg-danger {
        background: #ff3333 !important;
        color: #ffffff !important;
    }
    .pc-text {
        text-align: center;
        width: 100%;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        margin-top: 5px;
        margin-bottom: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row text-center justify-content-center">
        @foreach($statusArray as $status)
        <div class="col-6 col-md-2 col-lg-2 upper">
            <div class="upper-block">
            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{$loop->index}}">
                <img src="{{url('/images/computer.png')}}" class="img img-fluid {{ in_array($status, $seats) ? 'bg-success' : 'bg-danger' }} img-computer"  />
            </a>
            <p class="pc-text">
                {{ $status }}
            </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@foreach($statusArray as $index => $status)
<div class="modal fade" id="exampleModal{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-start"> 
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Member ID</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(in_array($status, $seats) && isset($seatMemberIds[$status]))
                    <p><strong>Member ID :</strong> {{ $seatMemberIds[$status] }}</p>
                    <p><strong>Online Time :</strong> {{ \Carbon\Carbon::parse($seatOnlineTimes[$status])->format('H:i:s') }}</p>
                    <p><strong>Online :</strong> {{ \Carbon\Carbon::parse($seatOnlineTimes[$status])->diffForHumans() }}</p>
                @else
                    <p>Available</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

