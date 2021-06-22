            @inject('medias', 'App\Models\Media')
            @php
                $medias = $medias::all();
                $countMedias = count($medias->all());
            @endphp
            <div class="row {{ $countMedias === 0 ? 'dropzone default-start' : '' }}">
                <div class="col-12 {{ $countMedias > 0 ? 'dropzone col-lg-8' : '' }}">

                    @if($countMedias > 0)
                        @foreach($medias as $media)
                            <div class="col-lg-2 col-12">
                                <a data-id="{{ $media->id }}" data-action="{{ route('medias.update', ['media' => $media->id]) }}" data-informations='@json($media, true)' href="#" class="js-select-image image-{{ $media->id }}">
                                    <div class="card bg-dark text-white">
                                        <img src="{{ asset('/myuploads/medias') . '/' . $media->src }}" class="card-img" alt="">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                            <div class="col-12">
                                Aucuns médias ? Pas soucis soit vous faites du drag n' drop ou simplement cliquez sur ce bouton ci dessous <br>
                                <a class="js-trigger-dropzone" href="#">Add Media</a>
                            </div>
                    @endif
                </div>
                @if($countMedias > 0)
                    <div class="col-lg-4 col-12">
                        {!! form($updateMediaLibrary) !!}
                    </div>
                @endif
            </div>
