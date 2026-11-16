{{-- Reusable Aspect-Ratio Banner Image Cropper Modal --}}
<style>
    .cropper-stage-wrap {
        width: 100%;
        height: 430px;
        max-height: 58vh;
        background-color: #181c20;
        border-radius: 6px;
        overflow: hidden;
        position: relative;
    }
    .cropper-stage-wrap img#cropper-target-img {
        display: block;
        max-width: 100%;
    }
    .cropper-live-preview {
        width: 100%;
        height: 140px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
    }
    .banner-crop-feedback {
        margin-top: 6px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .banner-crop-thumb {
        height: 46px;
        max-width: 96px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        background: #f8f9fa;
    }
    .banner-crop-meta {
        display: flex;
        flex-direction: column;
        gap: 3px;
        font-size: 11.5px;
        line-height: 1.3;
    }
    .cropper-toolbar .btn {
        font-size: 12px;
        padding: 4px 9px;
    }
    @media (max-width: 767px) {
        .cropper-stage-wrap {
            height: 300px;
            max-height: 48vh;
        }
    }
</style>

<div class="modal fade" id="bannerCropperModal" tabindex="-1" aria-labelledby="bannerCropperModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 px-3">
                <div>
                    <h5 class="modal-title mb-0" id="bannerCropperModalLabel">
                        <i class="mdi mdi-crop me-1"></i> Image Cropper
                    </h5>
                    <small class="text-muted" id="cropper-slot-subtitle"></small>
                </div>
                <button type="button" class="btn-close cropper-cancel-action" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3">
                <div id="cropper-status-alert" class="alert py-2 px-3 mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2" style="font-size: 13px;">
                    <span id="cropper-status-message"></span>
                    <span class="badge bg-dark" id="cropper-ratio-badge"></span>
                </div>

                <div id="cropper-error-box" class="alert alert-danger py-2 px-3 mb-2 d-none" style="font-size: 13px;"></div>

                <div class="row g-3">
                    <div class="col-lg-9">
                        <div class="cropper-stage-wrap">
                            <img id="cropper-target-img" src="" alt="Image to crop">
                        </div>

                        <div class="cropper-toolbar d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2">
                            <div class="btn-group" role="group" aria-label="Zoom and mode">
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="zoom" data-val="0.1" title="Zoom In">
                                    <i class="mdi mdi-magnify-plus-outline"></i> Zoom +
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="zoom" data-val="-0.1" title="Zoom Out">
                                    <i class="mdi mdi-magnify-minus-outline"></i> Zoom -
                                </button>
                                <button type="button" class="btn btn-outline-secondary active cropper-tool" data-cmd="dragMode" data-val="move" title="Pan Image">
                                    <i class="mdi mdi-cursor-move"></i> Move
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="dragMode" data-val="crop" title="Draw Crop Box">
                                    <i class="mdi mdi-crop"></i> Crop Box
                                </button>
                            </div>

                            <div class="btn-group" role="group" aria-label="Rotate and flip">
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="rotate" data-val="-90" title="Rotate Left">
                                    <i class="mdi mdi-rotate-left"></i> -90&deg;
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="rotate" data-val="90" title="Rotate Right">
                                    <i class="mdi mdi-rotate-right"></i> +90&deg;
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="scaleX" title="Flip Horizontal">
                                    <i class="mdi mdi-flip-horizontal"></i> Flip H
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="scaleY" title="Flip Vertical">
                                    <i class="mdi mdi-flip-vertical"></i> Flip V
                                </button>
                                <button type="button" class="btn btn-outline-secondary cropper-tool" data-cmd="reset" title="Reset">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </button>
                            </div>

                            <div class="btn-group d-none" id="cropper-aspect-toggle-group" role="group" aria-label="Aspect mode">
                                <button type="button" class="btn btn-outline-primary active" id="cropper-lock-ratio-btn">Slot Ratio</button>
                                <button type="button" class="btn btn-outline-primary" id="cropper-free-ratio-btn">Free</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card border mb-2">
                            <div class="card-body p-2">
                                <div class="fw-semibold mb-1" style="font-size: 12.5px;">Live Cropped Preview</div>
                                <div class="cropper-live-preview"></div>

                                <table class="table table-sm table-borderless mb-0 mt-2" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted ps-0 py-1">Target Size:</td>
                                            <td class="text-end fw-semibold pe-0 py-1" id="cropper-target-dims">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0 py-1">Original:</td>
                                            <td class="text-end pe-0 py-1" id="cropper-original-dims">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0 py-1">Selection:</td>
                                            <td class="text-end pe-0 py-1" id="cropper-selection-dims">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0 py-1">Output File:</td>
                                            <td class="text-end text-success fw-semibold pe-0 py-1" id="cropper-output-dims">-</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <hr class="my-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cropper-exact-size-toggle" checked>
                                    <label class="form-check-label" for="cropper-exact-size-toggle" style="font-size: 12px;">
                                        Resize output to exact recommended size
                                    </label>
                                </div>
                                <small id="cropper-lowres-note" class="text-warning d-none d-block mt-1" style="font-size: 11px;"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between py-2 px-3">
                <span class="text-muted" style="font-size: 12px;">
                    Drag handles to resize or drag image inside the frame.
                </span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm cropper-cancel-action">Cancel</button>
                    <button type="button" class="btn btn-outline-warning btn-sm d-none" id="cropper-keep-original-btn">
                        Keep Original (No Crop)
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="cropper-apply-btn">
                        <i class="mdi mdi-content-cut me-1"></i> Crop &amp; Apply
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('public/backEnd/assets/libs/cropper/cropper.min.js') }}"></script>
<script>
(function() {
    if (window.__bannerCropperInitialized) {
        return;
    }
    window.__bannerCropperInitialized = true;

    var PLACEMENT_SPECS = @json(\App\Models\BannerCategory::PLACEMENT_SPECS);
    var DEVICE_LABELS = {
        image: 'PC / Desktop',
        tablet_image: 'Tablet (768–1023px)',
        mobile_image: 'Mobile (<768px)'
    };
    var RATIO_TOLERANCE = 0.025; // 2.5% tolerance so near-exact sizes (e.g. 1600x950 vs 1080x640) pass automatically

    var inputStates = new WeakMap();
    var activeSession = null;
    var activeToken = 0;

    function getInputState(inputEl) {
        var st = inputStates.get(inputEl);
        if (!st) {
            st = {
                lastValidFile: null,
                status: null,
                actualW: null,
                actualH: null,
                previewUrl: null,
                objectUrlToRevoke: null,
                pendingToken: 0
            };
            inputStates.set(inputEl, st);
        }
        return st;
    }

    function resolveInputPlacement(inputEl) {
        var $el = $(inputEl);
        var fixed = $el.attr('data-placement');
        if (fixed) {
            return fixed;
        }
        var sourceSel = $el.attr('data-placement-source');
        if (sourceSel) {
            var $opt = $(sourceSel).find('option:selected');
            return $opt.attr('data-placement') || '';
        }
        return '';
    }

    function resolveTargetSpec(placement, device) {
        if (!placement || !PLACEMENT_SPECS[placement]) {
            return null;
        }
        var group = PLACEMENT_SPECS[placement];
        var dims = group[device] || group.image;
        if (!dims || !dims.w || !dims.h) {
            return null;
        }
        return {
            placement: placement,
            placementLabel: group.label || placement,
            device: device,
            deviceLabel: DEVICE_LABELS[device] || device,
            w: Number(dims.w),
            h: Number(dims.h),
            ratio: Number(dims.w) / Number(dims.h),
            allowFree: Boolean(group.allow_free)
        };
    }

    function isRatioMatched(actualW, actualH, targetRatio) {
        if (!actualW || !actualH || !targetRatio) {
            return true;
        }
        var actualRatio = actualW / actualH;
        return (Math.abs(actualRatio - targetRatio) / targetRatio) <= RATIO_TOLERANCE;
    }

    function formatRatioText(w, h) {
        if (!w || !h) return '-';
        return (w / h).toFixed(2) + ':1';
    }

    function assignFileToInput(inputEl, file) {
        if (typeof DataTransfer === 'undefined') {
            return false;
        }
        var dt = new DataTransfer();
        if (file) {
            dt.items.add(file);
        }
        inputEl.files = dt.files;
        if ($.fn.parsley && $(inputEl).data('Parsley')) {
            $(inputEl).parsley().reset();
        }
        return true;
    }

    function loadDimensions(src, onSuccess, onError) {
        var probe = new Image();
        probe.onload = function() {
            onSuccess(probe.naturalWidth, probe.naturalHeight);
        };
        probe.onerror = function() {
            if (onError) onError();
        };
        probe.src = src;
    }

    function hideFallbackPreview($input) {
        $input.siblings('.banner-existing-thumb').addClass('d-none');
    }

    function getOrCreateFeedback($input) {
        var $fb = $input.siblings('.banner-crop-feedback');
        if (!$fb.length) {
            $fb = $('<div class="banner-crop-feedback"></div>');
            var $existingThumb = $input.siblings('.banner-existing-thumb');
            if ($existingThumb.length) {
                $existingThumb.after($fb);
            } else {
                $input.after($fb);
            }
        }
        return $fb;
    }

    function renderInputFeedback(inputEl) {
        var $input = $(inputEl);
        var state = getInputState(inputEl);
        var placement = resolveInputPlacement(inputEl);
        var device = $input.attr('data-device') || 'image';
        var spec = resolveTargetSpec(placement, device);
        var $fb = getOrCreateFeedback($input);

        var thumbSrc = state.previewUrl || $input.attr('data-existing-src') || '';
        if (!thumbSrc) {
            $fb.empty().addClass('d-none');
            return;
        }

        hideFallbackPreview($input);
        $fb.removeClass('d-none').empty();

        var $thumb = $('<img class="banner-crop-thumb" alt="Preview">').attr('src', thumbSrc);
        var $meta = $('<div class="banner-crop-meta"></div>');

        if (state.actualW && state.actualH) {
            var dimText = state.actualW + '×' + state.actualH + ' px';
            var matched = !spec || spec.allowFree || isRatioMatched(state.actualW, state.actualH, spec.ratio);

            if (state.status === 'cropped') {
                $meta.append(
                    $('<span class="badge bg-soft-success text-success align-self-start"></span>')
                        .text('Cropped (' + dimText + ') — Ready to submit')
                );
            } else if (matched) {
                $meta.append(
                    $('<span class="badge bg-soft-success text-success align-self-start"></span>')
                        .text(spec ? ('Ratio OK (' + dimText + ')') : ('Image (' + dimText + ')'))
                );
            } else {
                $meta.append(
                    $('<span class="badge bg-soft-warning text-warning align-self-start"></span>')
                        .text('Ratio mismatch: ' + dimText + ' (need ' + spec.w + '×' + spec.h + ')')
                );
            }
        } else {
            $meta.append(
                $('<span class="text-muted"></span>').text('Current saved image')
            );
        }

        var isMismatchStatus = Boolean(state.actualW && state.actualH && spec && !spec.allowFree && !isRatioMatched(state.actualW, state.actualH, spec.ratio));
        var btnLabel = state.lastValidFile
            ? (isMismatchStatus ? 'Cut to Ratio' : 'Adjust / Crop')
            : (isMismatchStatus ? 'Cut Current Image' : 'Crop Current');
        var btnClass = isMismatchStatus
            ? 'btn btn-xs btn-warning align-self-start banner-open-crop-btn'
            : 'btn btn-xs btn-outline-primary align-self-start banner-open-crop-btn';

        var $cropBtn = $('<button type="button"></button>')
            .addClass(btnClass)
            .html('<i class="mdi mdi-crop"></i> ' + btnLabel);

        $cropBtn.on('click', function() {
            openCropperForInput(inputEl, true);
        });

        $meta.append($cropBtn);
        $fb.append($thumb, $meta);
    }

    function updateDynamicDimensionHints() {
        var $catSelect = $('#category_id');
        if (!$catSelect.length) return;
        var placement = $catSelect.find('option:selected').attr('data-placement') || '';

        $('.banner-crop-input[data-placement-source="#category_id"]').each(function() {
            var device = $(this).attr('data-device') || 'image';
            var spec = resolveTargetSpec(placement, device);
            var targetId = $(this).attr('id');
            var $hint = $('.cropper-dim-hint[data-for="' + targetId + '"]');
            if ($hint.length) {
                var defaultHint = $hint.attr('data-default-hint') || '';
                if (spec) {
                    $hint.text(device !== 'image'
                        ? '(Optional — ' + spec.w + '×' + spec.h + ' px, falls back to PC image)'
                        : '(' + spec.w + '×' + spec.h + ' px)');
                } else if (defaultHint) {
                    $hint.text(defaultHint);
                } else {
                    $hint.text(device !== 'image' ? '(Optional — falls back to PC image)' : '');
                }
            }
        });
    }

    function syncExistingImages() {
        $('.banner-crop-input').each(function() {
            var inputEl = this;
            var $input = $(inputEl);
            var existingSrc = $input.attr('data-existing-src');
            var state = getInputState(inputEl);
            if (existingSrc && !state.lastValidFile && !state.actualW) {
                loadDimensions(existingSrc, function(w, h) {
                    state.actualW = w;
                    state.actualH = h;
                    renderInputFeedback(inputEl);
                }, function() {
                    renderInputFeedback(inputEl);
                });
            } else if (state.lastValidFile || existingSrc) {
                renderInputFeedback(inputEl);
            }
        });
    }

    function computeOutputSize(cropW, cropH) {
        var spec = activeSession ? activeSession.spec : null;
        var exactChecked = $('#cropper-exact-size-toggle').is(':checked');
        var cw = Math.max(1, Math.round(cropW || 0));
        var ch = Math.max(1, Math.round(cropH || 0));
        var lockAspect = activeSession ? activeSession.lockAspect : true;

        if (spec && lockAspect && exactChecked) {
            return { w: spec.w, h: spec.h, upscaled: cw < spec.w };
        }

        var maxW = spec ? Math.round(spec.w * 1.5) : 1920;
        if (cw > maxW) {
            var scaledW = maxW;
            var scaledH = Math.max(1, Math.round(ch * (maxW / cw)));
            return { w: scaledW, h: scaledH, upscaled: false };
        }
        return { w: cw, h: ch, upscaled: false };
    }

    function updateOutputPreviewDims(cropW, cropH) {
        var out = computeOutputSize(cropW, cropH);
        $('#cropper-output-dims').text(out.w + ' × ' + out.h + ' px');

        var $note = $('#cropper-lowres-note');
        if (activeSession && activeSession.spec && cropW > 0 && cropW < activeSession.spec.w) {
            $note.removeClass('d-none').text(
                'Note: Selected crop width (' + Math.round(cropW) + 'px) is smaller than ' + activeSession.spec.w + 'px.'
            );
        } else {
            $note.addClass('d-none').text('');
        }
    }

    function buildCropperOnVisibleModal() {
        if (!activeSession) return;
        var $img = $('#cropper-target-img');
        if ($img.data('cropper')) {
            $img.cropper('destroy');
        }

        var $previewBox = $('.cropper-live-preview');
        var ratio = activeSession.spec && activeSession.lockAspect ? activeSession.spec.ratio : (16 / 9);
        var pWidth = $previewBox.width() || 220;
        var pHeight = Math.max(70, Math.min(180, Math.round(pWidth / ratio)));
        $previewBox.css('height', pHeight + 'px');

        var aspectToEnforce = activeSession.spec && activeSession.lockAspect
            ? activeSession.spec.ratio
            : NaN;

        $img.cropper({
            aspectRatio: aspectToEnforce,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            responsive: true,
            restore: false,
            guides: true,
            center: true,
            highlight: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: true,
            preview: '.cropper-live-preview',
            crop: function(e) {
                var cw = Math.max(1, Math.round(e.detail.width || 0));
                var ch = Math.max(1, Math.round(e.detail.height || 0));
                $('#cropper-selection-dims').text(cw + ' × ' + ch + ' px');
                updateOutputPreviewDims(cw, ch);
            }
        });
    }

    function openCropperModal(session) {
        activeSession = session;
        activeSession.actionTaken = false;
        activeSession.scaleX = 1;
        activeSession.scaleY = 1;
        activeSession.lockAspect = session.spec ? true : false;

        $('#cropper-error-box').addClass('d-none').text('');
        $('#cropper-apply-btn').prop('disabled', false).html('<i class="mdi mdi-content-cut me-1"></i> Crop &amp; Apply');
        $('.cropper-tool[data-cmd="dragMode"]').removeClass('active');
        $('.cropper-tool[data-cmd="dragMode"][data-val="move"]').addClass('active');

        var spec = session.spec;
        if (spec) {
            $('#cropper-slot-subtitle').text(spec.placementLabel + ' · ' + spec.deviceLabel);
            $('#cropper-target-dims').text(spec.w + ' × ' + spec.h + ' px');
            $('#cropper-ratio-badge').text('Ratio ' + formatRatioText(spec.w, spec.h) + ' (' + spec.w + '×' + spec.h + ')');
            $('#cropper-exact-size-toggle').prop('disabled', false).prop('checked', true);
        } else {
            $('#cropper-slot-subtitle').text('Custom Banner · ' + (DEVICE_LABELS[session.device] || 'Image'));
            $('#cropper-target-dims').text('Free / Custom');
            $('#cropper-ratio-badge').text('Free Aspect Ratio');
            $('#cropper-exact-size-toggle').prop('checked', false).prop('disabled', true);
        }

        $('#cropper-original-dims').text(
            session.actualW + ' × ' + session.actualH + ' px (' + formatRatioText(session.actualW, session.actualH) + ')'
        );

        var $alert = $('#cropper-status-alert');
        $alert.removeClass('alert-warning alert-success alert-info');
        if (spec && !spec.allowFree && session.isMismatch) {
            $alert.addClass('alert-warning');
            $('#cropper-status-message').html(
                '<strong>Ratio Mismatch!</strong> Your image is <strong>' + session.actualW + '×' + session.actualH + '</strong> (' + formatRatioText(session.actualW, session.actualH) + '), but this slot requires <strong>' + spec.w + '×' + spec.h + '</strong> (' + formatRatioText(spec.w, spec.h) + '). Drag or zoom to crop.'
            );
        } else if (spec) {
            $alert.addClass('alert-success');
            $('#cropper-status-message').html(
                'Adjust frame, zoom, or rotate if needed and click <strong>Crop &amp; Apply</strong>.'
            );
        } else {
            $alert.addClass('alert-info');
            $('#cropper-status-message').html(
                'No fixed placement ratio selected — crop freely and click <strong>Crop &amp; Apply</strong>.'
            );
        }

        if (spec && spec.allowFree) {
            $('#cropper-aspect-toggle-group').removeClass('d-none');
            $('#cropper-lock-ratio-btn').addClass('active');
            $('#cropper-free-ratio-btn').removeClass('active');
        } else {
            $('#cropper-aspect-toggle-group').addClass('d-none');
        }

        if (session.file && !session.isManualAdjust) {
            $('#cropper-keep-original-btn').removeClass('d-none');
        } else {
            $('#cropper-keep-original-btn').addClass('d-none');
        }

        var $img = $('#cropper-target-img');
        if ($img.data('cropper')) {
            $img.cropper('destroy');
        }
        $img.attr('src', session.srcUrl);

        $('#bannerCropperModal').modal('show');
    }

    function openCropperForInput(inputEl, isManualAdjust) {
        var $input = $(inputEl);
        var state = getInputState(inputEl);
        var placement = resolveInputPlacement(inputEl);
        var device = $input.attr('data-device') || 'image';
        var spec = resolveTargetSpec(placement, device);

        if (state.lastValidFile) {
            var fileUrl = URL.createObjectURL(state.lastValidFile);
            loadDimensions(fileUrl, function(w, h) {
                openCropperModal({
                    inputEl: inputEl,
                    file: state.lastValidFile,
                    srcUrl: fileUrl,
                    revokeOnClose: true,
                    spec: spec,
                    actualW: w,
                    actualH: h,
                    isMismatch: spec ? !isRatioMatched(w, h, spec.ratio) : false,
                    isManualAdjust: Boolean(isManualAdjust),
                    isExistingServer: false
                });
            }, function() {
                URL.revokeObjectURL(fileUrl);
            });
            return;
        }

        var existingSrc = $input.attr('data-existing-src');
        if (existingSrc) {
            loadDimensions(existingSrc, function(w, h) {
                openCropperModal({
                    inputEl: inputEl,
                    file: null,
                    srcUrl: existingSrc,
                    revokeOnClose: false,
                    spec: spec,
                    actualW: w,
                    actualH: h,
                    isMismatch: spec ? !isRatioMatched(w, h, spec.ratio) : false,
                    isManualAdjust: true,
                    isExistingServer: true
                });
            }, function() {
                alert('Unable to load existing image for cropping.');
            });
        }
    }

    // Handle modal shown -> initialize Cropper once modal dimensions are known
    $('#bannerCropperModal').on('shown.bs.modal', function() {
        if (!activeSession) return;
        var targetImg = document.getElementById('cropper-target-img');
        if (targetImg.complete && targetImg.naturalWidth > 0) {
            buildCropperOnVisibleModal();
        } else {
            $(targetImg).one('load', function() {
                buildCropperOnVisibleModal();
            });
        }
    });

    // Handle modal hidden -> destroy cropper cleanly & handle cancel rollback
    $('#bannerCropperModal').on('hidden.bs.modal', function() {
        var $img = $('#cropper-target-img');
        if ($img.data('cropper')) {
            $img.cropper('destroy');
        }
        $img.attr('src', '');

        if (!activeSession) return;
        var session = activeSession;
        activeSession = null;

        if (session.revokeOnClose && session.srcUrl) {
            URL.revokeObjectURL(session.srcUrl);
        }

        if (!session.actionTaken && !session.isManualAdjust) {
            var state = getInputState(session.inputEl);
            if (state.lastValidFile) {
                assignFileToInput(session.inputEl, state.lastValidFile);
            } else {
                session.inputEl.value = '';
            }
            renderInputFeedback(session.inputEl);
        }
    });

    // Close / Cancel buttons
    $(document).on('click', '.cropper-cancel-action', function() {
        if (activeSession) {
            activeSession.actionTaken = false;
        }
        $('#bannerCropperModal').modal('hide');
    });

    // Keep Original without cropping
    $(document).on('click', '#cropper-keep-original-btn', function() {
        if (!activeSession || !activeSession.file) return;
        var session = activeSession;
        session.actionTaken = true;
        var state = getInputState(session.inputEl);
        if (state.objectUrlToRevoke) {
            URL.revokeObjectURL(state.objectUrlToRevoke);
        }
        var url = URL.createObjectURL(session.file);
        state.lastValidFile = session.file;
        state.status = 'mismatched';
        state.actualW = session.actualW;
        state.actualH = session.actualH;
        state.previewUrl = url;
        state.objectUrlToRevoke = url;
        assignFileToInput(session.inputEl, session.file);
        renderInputFeedback(session.inputEl);
        $('#bannerCropperModal').modal('hide');
    });

    // Toolbar controls
    $(document).on('click', '.cropper-tool', function() {
        if (!activeSession) return;
        var $img = $('#cropper-target-img');
        if (!$img.data('cropper')) return;
        var cmd = $(this).data('cmd');
        var val = $(this).data('val');

        if (cmd === 'zoom') {
            $img.cropper('zoom', Number(val));
        } else if (cmd === 'dragMode') {
            $img.cropper('setDragMode', val);
            $('.cropper-tool[data-cmd="dragMode"]').removeClass('active');
            $(this).addClass('active');
        } else if (cmd === 'rotate') {
            var ratio = activeSession.spec && activeSession.lockAspect ? activeSession.spec.ratio : NaN;
            $img.cropper('clear').cropper('rotate', Number(val)).cropper('crop');
            if (!Number.isNaN(ratio)) {
                $img.cropper('setAspectRatio', ratio);
            }
        } else if (cmd === 'scaleX') {
            activeSession.scaleX = activeSession.scaleX === 1 ? -1 : 1;
            $img.cropper('scaleX', activeSession.scaleX);
        } else if (cmd === 'scaleY') {
            activeSession.scaleY = activeSession.scaleY === 1 ? -1 : 1;
            $img.cropper('scaleY', activeSession.scaleY);
        } else if (cmd === 'reset') {
            activeSession.scaleX = 1;
            activeSession.scaleY = 1;
            $img.cropper('reset');
        }
    });

    // Toggle exact size output vs higher-res
    $(document).on('change', '#cropper-exact-size-toggle', function() {
        var $img = $('#cropper-target-img');
        if (!$img.data('cropper') || !activeSession) return;
        var d = $img.cropper('getData', true);
        updateOutputPreviewDims(d.width, d.height);
    });

    // Optional Free / Slot Ratio toggle for flexible placements
    $(document).on('click', '#cropper-lock-ratio-btn', function() {
        if (!activeSession || !activeSession.spec) return;
        activeSession.lockAspect = true;
        $(this).addClass('active');
        $('#cropper-free-ratio-btn').removeClass('active');
        $('#cropper-exact-size-toggle').prop('disabled', false);
        $('#cropper-target-img').cropper('setAspectRatio', activeSession.spec.ratio);
    });

    $(document).on('click', '#cropper-free-ratio-btn', function() {
        if (!activeSession) return;
        activeSession.lockAspect = false;
        $(this).addClass('active');
        $('#cropper-lock-ratio-btn').removeClass('active');
        $('#cropper-exact-size-toggle').prop('checked', false).prop('disabled', true);
        $('#cropper-target-img').cropper('setAspectRatio', NaN);
    });

    // Crop & Apply
    $(document).on('click', '#cropper-apply-btn', function() {
        if (!activeSession) return;
        var $img = $('#cropper-target-img');
        if (!$img.data('cropper')) return;

        var session = activeSession;
        var $btn = $(this);
        var data = $img.cropper('getData', true);
        var outSize = computeOutputSize(data.width, data.height);

        var origMime = session.file ? session.file.type : '';
        var origSrcName = session.file ? session.file.name : (session.srcUrl.split('/').pop().split('?')[0] || 'banner.jpg');
        var extLower = (origSrcName.split('.').pop() || '').toLowerCase();

        var outMime = 'image/jpeg';
        var outExt = 'jpg';
        if (origMime === 'image/png' || extLower === 'png') {
            outMime = 'image/png';
            outExt = 'png';
        } else if (origMime === 'image/webp' || extLower === 'webp') {
            outMime = 'image/webp';
            outExt = 'webp';
        }

        var canvasOpts = {
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        };
        if (outMime === 'image/jpeg') {
            canvasOpts.fillColor = '#ffffff';
        }
        if (session.spec && session.lockAspect && ($('#cropper-exact-size-toggle').is(':checked') || outSize.w !== Math.round(data.width))) {
            canvasOpts.width = outSize.w;
            canvasOpts.height = outSize.h;
        } else if (outSize.w < Math.round(data.width)) {
            canvasOpts.width = outSize.w;
            canvasOpts.height = outSize.h;
        }

        var canvas;
        try {
            canvas = $img.cropper('getCroppedCanvas', canvasOpts);
        } catch (err) {
            $('#cropper-error-box').removeClass('d-none').text('Could not crop this image in browser: ' + (err.message || err));
            return;
        }

        if (!canvas) {
            $('#cropper-error-box').removeClass('d-none').text('Failed to generate cropped canvas.');
            return;
        }

        // Normalize off-by-1px float rounding when exact target dimensions are enabled
        if (session.spec && session.lockAspect && canvasOpts.width && canvasOpts.height &&
            (canvas.width !== canvasOpts.width || canvas.height !== canvasOpts.height)) {
            var exactCanvas = document.createElement('canvas');
            exactCanvas.width = canvasOpts.width;
            exactCanvas.height = canvasOpts.height;
            var exactCtx = exactCanvas.getContext('2d');
            if (outMime === 'image/jpeg') {
                exactCtx.fillStyle = '#ffffff';
                exactCtx.fillRect(0, 0, exactCanvas.width, exactCanvas.height);
            }
            exactCtx.imageSmoothingEnabled = true;
            exactCtx.imageSmoothingQuality = 'high';
            exactCtx.drawImage(canvas, 0, 0, exactCanvas.width, exactCanvas.height);
            canvas = exactCanvas;
        }

        $btn.prop('disabled', true).text('Applying...');

        var finalizeBlob = function(blob, usedMime, usedExt) {
            if (!blob) {
                $btn.prop('disabled', false).html('<i class="mdi mdi-content-cut me-1"></i> Crop &amp; Apply');
                $('#cropper-error-box').removeClass('d-none').text('Failed to encode cropped image.');
                return;
            }

            var cleanBase = origSrcName.replace(/\.[^/.]+$/, '').replace(/[^a-zA-Z0-9_-]+/g, '-').slice(0, 40) || 'banner';
            var finalName = cleanBase + '-' + canvas.width + 'x' + canvas.height + '.' + usedExt;
            var croppedFile = new File([blob], finalName, {
                type: usedMime,
                lastModified: Date.now()
            });

            session.actionTaken = true;
            var state = getInputState(session.inputEl);
            if (state.objectUrlToRevoke) {
                URL.revokeObjectURL(state.objectUrlToRevoke);
            }
            var previewUrl = URL.createObjectURL(croppedFile);
            state.lastValidFile = croppedFile;
            state.status = 'cropped';
            state.actualW = canvas.width;
            state.actualH = canvas.height;
            state.previewUrl = previewUrl;
            state.objectUrlToRevoke = previewUrl;

            assignFileToInput(session.inputEl, croppedFile);
            renderInputFeedback(session.inputEl);
            $('#bannerCropperModal').modal('hide');
        };

        try {
            canvas.toBlob(function(blob) {
                if (!blob && outMime !== 'image/jpeg') {
                    canvas.toBlob(function(fbBlob) {
                        finalizeBlob(fbBlob, 'image/jpeg', 'jpg');
                    }, 'image/jpeg', 0.92);
                    return;
                }
                finalizeBlob(blob, outMime, outExt);
            }, outMime, 0.92);
        } catch (err) {
            $btn.prop('disabled', false).html('<i class="mdi mdi-content-cut me-1"></i> Crop &amp; Apply');
            $('#cropper-error-box').removeClass('d-none').text('Browser blocked canvas export: ' + (err.message || err));
        }
    });

    // Listen to file selection across existing and dynamically added banner inputs
    $(document).on('change', '.banner-crop-input', function() {
        var inputEl = this;
        var file = inputEl.files && inputEl.files[0];
        var state = getInputState(inputEl);

        if (!file) {
            state.lastValidFile = null;
            state.status = null;
            state.previewUrl = null;
            state.actualW = null;
            state.actualH = null;
            if (state.objectUrlToRevoke) {
                URL.revokeObjectURL(state.objectUrlToRevoke);
                state.objectUrlToRevoke = null;
            }
            if ($(inputEl).attr('data-existing-src')) {
                syncExistingImages();
            } else {
                renderInputFeedback(inputEl);
            }
            return;
        }

        if (!/^image\//.test(file.type)) {
            alert('Please choose a valid image file.');
            inputEl.value = '';
            return;
        }

        var token = ++activeToken;
        state.pendingToken = token;

        var placement = resolveInputPlacement(inputEl);
        var device = $(inputEl).attr('data-device') || 'image';
        var spec = resolveTargetSpec(placement, device);

        var tempUrl = URL.createObjectURL(file);
        loadDimensions(tempUrl, function(w, h) {
            if (state.pendingToken !== token) {
                URL.revokeObjectURL(tempUrl);
                return;
            }

            if (spec && !spec.allowFree && !isRatioMatched(w, h, spec.ratio)) {
                openCropperModal({
                    inputEl: inputEl,
                    file: file,
                    srcUrl: tempUrl,
                    revokeOnClose: true,
                    spec: spec,
                    actualW: w,
                    actualH: h,
                    isMismatch: true,
                    isManualAdjust: false,
                    isExistingServer: false
                });
                return;
            }

            // Ratio matched (or free-ratio category): accept immediately and offer optional Adjust Crop
            if (state.objectUrlToRevoke) {
                URL.revokeObjectURL(state.objectUrlToRevoke);
            }
            state.lastValidFile = file;
            state.status = 'matched';
            state.actualW = w;
            state.actualH = h;
            state.previewUrl = tempUrl;
            state.objectUrlToRevoke = tempUrl;
            renderInputFeedback(inputEl);
        }, function() {
            URL.revokeObjectURL(tempUrl);
            alert('Could not read image dimensions.');
        });
    });

    // Re-check ratios & labels if user changes Banner Category dropdown
    $(document).on('change select2:select', '#category_id', function() {
        updateDynamicDimensionHints();
        $('.banner-crop-input[data-placement-source="#category_id"]').each(function() {
            renderInputFeedback(this);
        });
    });

    $(document).ready(function() {
        updateDynamicDimensionHints();
        syncExistingImages();
    });
})();
</script>
