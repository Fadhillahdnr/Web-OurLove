@extends('layouts.app')

@section('title', 'Tambah Moment 💖')

@section('content')

<section class="min-vh-100 d-flex align-items-center justify-content-center" 
         style="background: linear-gradient(135deg,#ffd6e7,#fff0f5); padding:100px 0;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="romantic-card p-5 shadow-lg">

                    <div class="text-center mb-4">
                        <h2 class="mb-2 fw-bold">Tambah Moment 💕</h2>
                        <p class="text-muted">Simpan kenangan indah kalian di sini</p>
                    </div>

                    <form action="{{ route('moments.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Judul --}}
                        <div class="mb-4">
                            <label class="form-label">Judul Moment</label>
                            <input type="text" 
                                   name="title" 
                                   class="form-control romantic-input"
                                   placeholder="Contoh: First Date 💖"
                                   required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" 
                                      class="form-control romantic-input"
                                      rows="4"
                                      placeholder="Ceritakan moment ini..."
                                      required></textarea>
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" 
                                   name="date" 
                                   class="form-control romantic-input"
                                   required>
                        </div>

                        {{-- Thumbnail Utama --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Thumbnail Utama</label>

                            <div class="upload-box text-center p-4">
                                <input type="file" 
                                       name="image" 
                                       id="imageInput"
                                       class="d-none"
                                       accept="image/*"
                                       required>

                                <label for="imageInput" class="upload-label">
                                    📸 Klik untuk pilih foto utama
                                </label>

                                <div class="mt-3">
                                    <img id="previewImage" 
                                         class="img-fluid rounded d-none"
                                         style="max-height:200px;">
                                </div>
                            </div>
                        </div>

                        {{-- Multiple Media --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Tambahan Foto / Video (Bisa banyak)
                            </label>

                            <input type="file" 
                                   name="media[]" 
                                   id="mediaInput"
                                   class="form-control romantic-input"
                                   multiple
                                   accept="image/*,video/*">

                            <small class="text-muted">
                                Bisa upload beberapa foto atau video sekaligus
                            </small>

                            {{-- Preview Multiple --}}
                            <div class="row mt-3" id="mediaPreview"></div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-romantic px-5 py-2">
                                Simpan Moment 💗
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

</section>

{{-- Preview Script --}}
<script>
/* Preview Thumbnail */
document.getElementById('imageInput').addEventListener('change', function(e){
    const preview = document.getElementById('previewImage');
    const file = e.target.files[0];

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
});

/* Preview Multiple Media */
document.getElementById('mediaInput').addEventListener('change', function(e){
    const previewContainer = document.getElementById('mediaPreview');
    previewContainer.innerHTML = '';

    Array.from(e.target.files).forEach(file => {

        const col = document.createElement('div');
        col.classList.add('col-md-4','mb-3');

        if(file.type.startsWith('image/')){
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.classList.add('img-fluid','rounded','shadow');
            img.style.height = '150px';
            img.style.objectFit = 'cover';
            col.appendChild(img);
        }

        if(file.type.startsWith('video/')){
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.classList.add('w-100','rounded','shadow');
            video.style.height = '150px';
            video.style.objectFit = 'cover';
            col.appendChild(video);
        }

        previewContainer.appendChild(col);
    });
});
</script>

@endsection