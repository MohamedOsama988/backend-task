@function cardss ($data) {
<div class="col mt-5" id="cards-all">
    <div id="cards">
        <div class="card" style="width: 18rem;">
            <img src="{{ $data->img_src }}" class="card-img-top" alt="..." height="300px">
            <div class="card-body" style="height: 5rem;">
                <h5 class="card-title m-0 display-inline overflow-hidden">{{ $data->title }}</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{ $data->pages_count }}</li>
                <li class="list-group-item">{{ $data->author }}</li>
                <li class="list-group-item">{{ $data->publisher }}</li>
            </ul>
            <div class="card-body bg-danger">
                <a href="{{ $data->pdf_src }}" class="card-link" style="text-decoration: none; color:white; font-weight: bold;">Download</a>
            </div>
        </div>
    </div>
</div>}

