@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-upload me-2"></i> Upload Image
                </div>
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Select Image</label>
                            <div class="input-group">
                                <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload
                                </button>
                            </div>
                            <div class="form-text">Supported formats: JPG, PNG, WebP, GIF (max 10MB)</div>
                        </div>
                    </form>
                    <div id="uploadProgress" class="progress mt-3 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                            style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="processingSection" class="d-none">
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-image me-2"></i> Original Image
                    </div>
                    <div class="card-body text-center">
                        <div class="crop-container mb-3">
                            <img id="cropperImage" class="img-fluid d-none" alt="Cropper Image">
                            <img id="originalImage" class="img-fluid img-preview" alt="Original Image">
                        </div>
                        <div id="cropControls" class="d-none">
                            <div class="btn-group mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="cropRotateLeft">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="cropRotateRight">
                                    <i class="fas fa-redo"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="cropFlipH">
                                    <i class="fas fa-arrows-alt-h"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="cropFlipV">
                                    <i class="fas fa-arrows-alt-v"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="cropReset">
                                    <i class="fas fa-sync"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-magic me-2"></i> Processed Image
                    </div>
                    <div class="card-body text-center">
                        <div id="processedImageContainer">
                            <div id="processingLoader" class="loader d-none"></div>
                            <img id="processedImage" class="img-fluid img-preview d-none" alt="Processed Image">
                        </div>
                        <a id="downloadBtn" class="btn btn-success mt-3 d-none" href="#">
                            <i class="fas fa-download me-2"></i> Download Image
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-sliders-h me-2"></i> Image Processing Options
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold mb-3">
                                    <i class="fas fa-palette me-2"></i> Select Filter
                                </label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center selected" data-filter="none">
                                    <div class="filter-preview">
                                        <span>Original</span>
                                    </div>
                                    <span class="filter-label">None</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="ghibli">
                                    <div class="filter-preview">
                                        <span>Ghibli</span>
                                    </div>
                                    <span class="filter-label">Ghibli</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="grayscale">
                                    <div class="filter-preview">
                                        <span>Gray</span>
                                    </div>
                                    <span class="filter-label">Grayscale</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="sepia">
                                    <div class="filter-preview">
                                        <span>Sepia</span>
                                    </div>
                                    <span class="filter-label">Sepia</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="vintage">
                                    <div class="filter-preview">
                                        <span>Vintage</span>
                                    </div>
                                    <span class="filter-label">Vintage</span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="bright">
                                    <div class="filter-preview">
                                        <span>Bright</span>
                                    </div>
                                    <span class="filter-label">Bright</span>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="warm">
                                    <div class="filter-preview">
                                        <span>warm</span>
                                    </div>
                                    <span class="filter-label">warm</span>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="filter-option text-center" data-filter="cool">
                                    <div class="filter-preview">
                                        <span>Cool</span>
                                    </div>
                                    <span class="filter-label">Cool</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="formatSelect" class="form-label fw-bold">
                                    <i class="fas fa-file-image me-2"></i> Format
                                </label>
                                <select class="form-select" id="formatSelect">
                                    <option value="jpg">JPG</option>
                                    <option value="png">PNG</option>
                                    <option value="webp">WebP</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold d-block">
                                    <i class="fas fa-crop-alt me-2"></i> Cropping
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="toggleCrop">
                                    <label class="form-check-label" for="toggleCrop">Enable Cropping</label>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold d-block">
                                    <i class="fas fa-expand-arrows-alt me-2"></i> Resizing
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="toggleResize">
                                    <label class="form-check-label" for="toggleResize">Enable Resizing</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 resize-options d-none">
                            <div class="col-md-6">
                                <label for="widthInput" class="form-label">Width (pixels)</label>
                                <input type="number" class="form-control" id="widthInput" placeholder="Width">
                            </div>
                            <div class="col-md-6">
                                <label for="heightInput" class="form-label">Height (pixels)</label>
                                <input type="number" class="form-control" id="heightInput" placeholder="Height">
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="maintainAspectRatio" checked>
                                    <label class="form-check-label" for="maintainAspectRatio">
                                        Maintain aspect ratio
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button id="processBtn" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-magic me-2"></i> Process Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let imageId = null;
        let cropper = null;
        let currentFilter = 'none';
        let originalWidth = 0;
        let originalHeight = 0;
        let aspectRatio = 0;

        $(document).ready(function () {
            // Handle file upload
            $('#uploadForm').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const fileInput = document.getElementById('image');

                if (!fileInput.files.length) {
                    alert('Please select an image to upload');
                    return;
                }

                $('#uploadProgress').removeClass('d-none');

                $.ajax({
                    url: '{{ route("images.upload") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                $('.progress-bar').css('width', percent + '%');
                            }
                        });
                        return xhr;
                    },
                    success: function (response) {
                        if (response.success) {
                            imageId = response.id;
                            $('#originalImage').attr('src', response.path);
                            $('#cropperImage').attr('src', response.path);

                            // Get original dimensions for aspect ratio
                            const img = new Image();
                            img.onload = function () {
                                originalWidth = this.width;
                                originalHeight = this.height;
                                aspectRatio = originalWidth / originalHeight;

                                // Pre-fill resize inputs with original dimensions
                                $('#widthInput').val(originalWidth);
                                $('#heightInput').val(originalHeight);
                            };
                            img.src = response.path;

                            $('#processingSection').removeClass('d-none');
                            $('html, body').animate({
                                scrollTop: $('#processingSection').offset().top - 20
                            }, 500);
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Error uploading image';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        alert(errorMessage);
                    },
                    complete: function () {
                        $('#uploadProgress').addClass('d-none');
                        $('.progress-bar').css('width', '0%');
                    }
                });
            });

            // Handle filter selection
            $('.filter-option').on('click', function () {
                $('.filter-option').removeClass('selected');
                $(this).addClass('selected');
                currentFilter = $(this).data('filter');
            });

            // Toggle crop functionality
            $('#toggleCrop').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#originalImage').addClass('d-none');
                    $('#cropperImage').removeClass('d-none');
                    $('#cropControls').removeClass('d-none');

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(document.getElementById('cropperImage'), {
                        aspectRatio: NaN,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        background: false,
                        guides: true,
                        center: true,
                        dragMode: 'move',
                        movable: true,
                        rotatable: true,
                        scalable: true,
                        zoomable: true,
                    });
                } else {
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                    $('#cropperImage').addClass('d-none');
                    $('#originalImage').removeClass('d-none');
                    $('#cropControls').addClass('d-none');
                }
            });

            // Crop control handlers
            $('#cropRotateLeft').on('click', function () {
                if (cropper) cropper.rotate(-90);
            });

            $('#cropRotateRight').on('click', function () {
                if (cropper) cropper.rotate(90);
            });

            $('#cropFlipH').on('click', function () {
                if (cropper) cropper.scaleX(-cropper.getData().scaleX || -1);
            });

            $('#cropFlipV').on('click', function () {
                if (cropper) cropper.scaleY(-cropper.getData().scaleY || -1);
            });

            $('#cropReset').on('click', function () {
                if (cropper) cropper.reset();
            });

            // Toggle resize options
            $('#toggleResize').on('change', function () {
                if ($(this).is(':checked')) {
                    $('.resize-options').removeClass('d-none');
                } else {
                    $('.resize-options').addClass('d-none');
                }
            });

            // Maintain aspect ratio in resize
            $('#widthInput').on('input', function () {
                if ($('#maintainAspectRatio').is(':checked') && aspectRatio > 0) {
                    const width = parseInt($(this).val()) || 0;
                    $('#heightInput').val(Math.round(width / aspectRatio));
                }
            });

            $('#heightInput').on('input', function () {
                if ($('#maintainAspectRatio').is(':checked') && aspectRatio > 0) {
                    const height = parseInt($(this).val()) || 0;
                    $('#widthInput').val(Math.round(height * aspectRatio));
                }
            });

            // Handle image processing
            $('#processBtn').on('click', function () {
                if (!imageId) {
                    alert('Please upload an image first');
                    return;
                }

                const filter = currentFilter === 'none' ? null : currentFilter;
                const format = $('#formatSelect').val();

                let data = {
                    filter: filter,
                    format: format,
                };

                // Add resize data if enabled
                if ($('#toggleResize').is(':checked')) {
                    const width = $('#widthInput').val();
                    const height = $('#heightInput').val();

                    if (width && height) {
                        data.width = width;
                        data.height = height;
                    } else {
                        alert('Please enter both width and height for resizing');
                        return;
                    }
                }

                // Add crop data if enabled
                if ($('#toggleCrop').is(':checked') && cropper) {
                    const cropData = cropper.getData();
                    data.crop_x = Math.round(cropData.x);
                    data.crop_y = Math.round(cropData.y);
                    data.crop_width = Math.round(cropData.width);
                    data.crop_height = Math.round(cropData.height);
                    data.rotate = cropData.rotate;
                    data.scaleX = cropData.scaleX;
                    data.scaleY = cropData.scaleY;
                }

                // Show processing loader
                $('#processingLoader').removeClass('d-none');
                $('#processedImage').addClass('d-none');
                $('#downloadBtn').addClass('d-none');

                $.ajax({
                    url: `/images/${imageId}/process`,
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#processedImage').attr('src', response.processed_url + '?t=' + new Date().getTime());
                            $('#processedImage').removeClass('d-none');
                            $('#downloadBtn').attr('href', response.download_url);
                            $('#downloadBtn').removeClass('d-none');
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Error processing image';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        alert(errorMessage);
                    },
                    complete: function () {
                        $('#processingLoader').addClass('d-none');
                    }
                });
            });

            // Show processed image when it's loaded
            $('#processedImage').on('load', function () {
                $(this).removeClass('d-none');
            });
        });
    </script>
@endsection