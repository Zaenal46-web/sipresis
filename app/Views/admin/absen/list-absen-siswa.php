<!-- BAGIAN HTML TABLE (sesuaikan dengan kode Anda yang sudah ada) -->
<div class="card-body">
    <div class="row">
        <div class="col-auto me-auto">
            <div class="pt-3 pl-3">
                <h4><b>Absen Siswa</b></h4>
                <p>Daftar siswa muncul disini</p>
            </div>
        </div>
        <div class="col">
            <a href="#" class="btn btn-success pl-3 mr-3 mt-3" style="background: #141C6E !important;" onclick="kelas = onDateChange()" data-toggle="tab">
                <i class="material-icons mr-2">refresh</i> Refresh
            </a>
        </div>
        <div class="col-auto">
            <div class="px-4">
                <h3 class="text-end">
                    <b class="text-primary"><?= $kelas; ?></b>
                </h3>
            </div>
        </div>
    </div>

    <div id="dataSiswa" class="card-body table-responsive pb-5">
        <?php if (!empty($data)) : ?>
            <table class="table table-hover">
                <thead class="text-primary">
                    <th><b>No.</b></th>
                    <th><b>NIS</b></th>
                    <th><b>Nama Siswa</b></th>
                    <th><b>Kehadiran</b></th>
                    <th><b>Jam masuk</b></th>
                    <th><b>Jam pulang</b></th>
                    <th><b>Keterangan</b></th>
                    <th><b>File surat</b></th>
                    <th><b>Aksi</b></th>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $value) : ?>
                        <?php
                        $idKehadiran = intval($value['id_kehadiran'] ?? ($lewat ? 5 : 4));
                        $kehadiran = kehadiran($idKehadiran);
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $value['nis']; ?></td>
                            <td><b><?= $value['nama_siswa']; ?></b></td>
                            <td>
                                <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                                    <b><?= $kehadiran['text']; ?></b>
                                </p>
                            </td>
                            <td><b><?= $value['jam_masuk'] ?? '-'; ?></b></td>
                            <td><b><?= $value['jam_keluar'] ?? '-'; ?></b></td>
                            <td><?= $value['keterangan'] ?? '-'; ?></td>
                            <td>
                                <?php if (!empty($value['file_surat'])): ?>
                                    <!-- Tombol View PDF dengan data attributes -->
                                    <button class="btn btn-danger p-2 pdf-viewer-btn" 
                                            data-pdf-file="<?= htmlspecialchars($value['file_surat']) ?>" 
                                            data-student-name="<?= htmlspecialchars($value['nama_siswa']) ?>"
                                            type="button">
                                        <i class="material-icons">picture_as_pdf</i> View PDF
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$lewat) : ?>
                                    <button data-toggle="modal" data-target="#ubahModal" 
                                            onclick="getDataKehadiran(<?= $value['id_presensi'] ?? '-1'; ?>, <?= $value['id_siswa']; ?>)" 
                                            class="btn btn-info p-2" id="<?= $value['nis']; ?>">
                                        <i class="material-icons">edit</i> Edit
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-secondary p-2" disabled>No Action</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="row">
                <div class="col">
                    <h4 class="text-center text-danger">Data tidak ditemukan</h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL PDF PREVIEW -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; margin: 1rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="pdfPreviewModalLabel">
                    <i class="material-icons mr-2">picture_as_pdf</i>
                    Preview Surat Keterangan
                </h5>
                <button type="button" class="close text-white close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <!-- Loading State -->
                <div id="pdf-loading" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="text-muted">Memuat dokumen PDF...</p>
                </div>
                
                <!-- PDF Container -->
                <div id="pdf-container" style="height: 70vh; min-height: 500px;">
                    <iframe id="pdf-frame" 
                            src="" 
                            width="100%" 
                            height="100%" 
                            frameborder="0"
                            style="border: none;">
                    </iframe>
                </div>
                
                <!-- Error State -->
                <div id="pdf-error" class="text-center py-5" style="display: none;">
                    <div class="alert alert-danger mx-4">
                        <h5><i class="material-icons">error</i> Gagal Memuat PDF</h5>
                        <p class="mb-3">Dokumen PDF tidak dapat ditampilkan. Kemungkinan penyebab:</p>
                        <ul class="text-left">
                            <li>File tidak ditemukan atau sudah dihapus</li>
                            <li>Browser tidak mendukung preview PDF</li>
                            <li>File PDF rusak atau terproteksi</li>
                        </ul>
                        <div class="mt-3">
                            <button id="pdf-retry-btn" class="btn btn-warning mr-2">
                                <i class="material-icons">refresh</i> Coba Lagi
                            </button>
                            <a id="pdf-download-btn" href="" class="btn btn-success" download>
                                <i class="material-icons">download</i> Download File
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <small class="text-muted mr-auto">
                    <i class="material-icons" style="font-size: 16px;">info</i>
                    Tip: Gunakan Ctrl+Mouse Wheel untuk zoom in/out
                </small>
                <a id="pdf-download-footer" href="" class="btn btn-outline-primary btn-sm" download>
                    <i class="material-icons">download</i> Download
                </a>
                <button type="button" class="btn btn-secondary btn-sm close-modal" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
// Pastikan script berjalan setelah DOM ready
$(document).ready(function() {
    console.log('PDF Viewer initialized');
    
    // Variables
    let currentPdfUrl = '';
    let currentFileName = '';
    let currentStudentName = '';
    
    // Event handler untuk tombol PDF viewer
    $(document).on('click', '.pdf-viewer-btn', function(e) {
        e.preventDefault();
        
        const fileName = $(this).data('pdf-file');
        const studentName = $(this).data('student-name');
        
        console.log('Opening PDF:', fileName, 'for student:', studentName);
        
        if (!fileName) {
            alert('Nama file tidak valid');
            return;
        }
        
        openPdfModal(fileName, studentName);
    });
    
    // Function untuk membuka modal PDF
    function openPdfModal(fileName, studentName) {
        currentFileName = fileName;
        currentStudentName = studentName;
        currentPdfUrl = '<?= base_url("uploads/surat/") ?>' + fileName;
        
        // Update modal title
        $('#pdfPreviewModalLabel').html(`
            <i class="material-icons mr-2">picture_as_pdf</i>
            Surat Keterangan - ${studentName}
        `);
        
        // Reset states
        showLoadingState();
        
        // Show modal
        $('#pdfPreviewModal').modal('show');
        
        // Load PDF setelah modal muncul
        setTimeout(() => {
            loadPdfDocument();
        }, 300);
    }
    
    // Function untuk load PDF
    function loadPdfDocument() {
        console.log('Loading PDF from:', currentPdfUrl);
        
        // Set download links
        $('#pdf-download-btn').attr('href', currentPdfUrl);
        $('#pdf-download-footer').attr('href', currentPdfUrl);
        
        // Check if file exists dengan HEAD request
        $.ajax({
            url: currentPdfUrl,
            type: 'HEAD',
            timeout: 5000,
            success: function() {
                console.log('PDF file exists, loading...');
                
                // Load PDF ke iframe
                const iframe = document.getElementById('pdf-frame');
                
                // Add parameters for better PDF display
                const pdfUrlWithParams = currentPdfUrl + '#toolbar=1&navpanes=1&scrollbar=1&page=1&view=FitH';
                
                iframe.onload = function() {
                    console.log('PDF loaded successfully');
                    showPdfState();
                };
                
                iframe.onerror = function() {
                    console.log('PDF load error');
                    showErrorState();
                };
                
                // Set iframe source
                iframe.src = pdfUrlWithParams;
                
                // Fallback timeout
                setTimeout(() => {
                    if ($('#pdf-loading').is(':visible')) {
                        console.log('PDF load timeout, showing content anyway');
                        showPdfState();
                    }
                }, 3000);
            },
            error: function(xhr, status, error) {
                console.log('PDF file not found:', status, error);
                showErrorState();
            }
        });
    }
    
    // State management functions
    function showLoadingState() {
        $('#pdf-loading').show();
        $('#pdf-container').hide();
        $('#pdf-error').hide();
    }
    
    function showPdfState() {
        $('#pdf-loading').hide();
        $('#pdf-container').show();
        $('#pdf-error').hide();
    }
    
    function showErrorState() {
        $('#pdf-loading').hide();
        $('#pdf-container').hide();
        $('#pdf-error').show();
    }
    
    // Retry button handler
    $(document).on('click', '#pdf-retry-btn', function() {
        showLoadingState();
        setTimeout(() => {
            loadPdfDocument();
        }, 500);
    });

    const btnClose = document.querySelectorAll('.close-modal');

    btnClose.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Close button clicked, resetting modal state');
            $('#pdfPreviewModal').modal('hide');
        });
    });
    
    // Modal cleanup saat ditutup
    $('#pdfPreviewModal').on('hidden.bs.modal', function() {
        console.log('Modal closed, cleaning up');
        
        // Clear iframe
        document.getElementById('pdf-frame').src = '';
        
        // Reset variables
        currentPdfUrl = '';
        currentFileName = '';
        currentStudentName = '';
        
        // Reset states
        showLoadingState();
    });
    
    // Handle modal shown event
    $('#pdfPreviewModal').on('shown.bs.modal', function() {
        console.log('Modal fully shown');
    });
});
</script>

<!-- ADDITIONAL CSS -->
<style>
/* PDF Modal Styles */
#pdfPreviewModal .modal-dialog {
    margin: 1rem;
}

#pdfPreviewModal .modal-content {
    height: 90vh;
    display: flex;
    flex-direction: column;
}

#pdfPreviewModal .modal-body {
    flex: 1;
    overflow: hidden;
}

#pdf-container iframe {
    border: none;
    background: #f8f9fa;
}

/* Loading animation */
.spinner-border {
    border-width: 0.2em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #pdfPreviewModal .modal-dialog {
        max-width: 98%;
        margin: 0.5rem;
    }
    
    #pdfPreviewModal .modal-content {
        height: 95vh;
    }
    
    #pdf-container {
        height: 60vh !important;
        min-height: 400px !important;
    }
}

/* Button improvements */
.pdf-viewer-btn:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
}

/* Error state styling */
#pdf-error .alert {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

#pdf-error ul {
    display: inline-block;
    text-align: left;
    margin: 0 auto;
}
</style>

<?php
function kehadiran($kehadiran): array
{
    $text = '';
    $color = '';
    switch ($kehadiran) {
        case 1:
            $color = 'success';
            $text = 'Hadir';
            break;
        case 2:
            $color = 'warning';
            $text = 'Sakit';
            break;
        case 3:
            $color = 'info';
            $text = 'Izin';
            break;
        case 4:
            $color = 'danger';
            $text = 'Tanpa keterangan';
            break;
        case 5:
        default:
            $color = 'disabled';
            $text = 'Belum tersedia';
            break;
    }

    return ['color' => $color, 'text' => $text];
}
?>