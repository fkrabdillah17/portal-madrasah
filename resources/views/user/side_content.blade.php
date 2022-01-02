    <div class="card shadow my-3">
        <h5 class="card-header text-center">Berita Terbaru</h5>
        <div class="card-body">
            @foreach ($news as $n)
                <div class="row">
                    <div class="col-4">
                        <a href="{{ route('show-berita', $n->slug) }}" class="linkBerita">
                            <img src="{{ asset('assets/img/news/' . $n->thumbnail) }}" class="img-thumbnail" alt="..."
                                style="height: 100px; width: 100px"></a>
                    </div>
                    <div class="col-8">
                        <a href="{{ route('show-berita', $n->slug) }}"
                            class="linkBerita text-uppercase">{{ \Illuminate\Support\Str::limit($n->title, 80, $end = '...') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card shadow my-3">
        <h5 class="card-header text-center">Kategori</h5>
        <div class="card-body">
            @foreach ($news_category as $t)
                <a class="btn btn-primary my-1" href="{{ route('kategori-berita', $t->category) }}" role="button">
                    <i class="bi bi-bookmark-dash-fill">{{ $t->category }}</i>
                </a>
            @endforeach
        </div>
    </div>
