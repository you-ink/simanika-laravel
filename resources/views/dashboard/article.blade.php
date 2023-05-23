@extends('app.dashboard')
@section('title', 'Article')

@include('dashboard.js.article')

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">ARTICLE</span>
            <h3 class="page-title">Data artikel</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="m-0">Data Artikel</h6>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-sm btn-success btn-add-article" data-toggle="modal"
                                data-target="#crudModalArticle"><i class="fas fa-plus"></i> Tambah Artikel </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 text-left">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No</th>
                                    <th scope="col" class="border-0">Judul</th>
                                    <th scope="col" class="border-0">Konten</th>
                                    <th scope="col" class="border-0">Sampul</th>
                                    <th scope="col" class="border-0">file</th>
                                    <th scope="col" class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- CRUD Modal -->
<div class="modal fade" id="crudModalArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span class="title-article-modal"></span> Artikel
                    <span class="article-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="articleName">Judul Artikel</label>
                            <input type="text" class="form-control" id="articleName" placeholder="Judul Article">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="articleContent">Konten</label>
                            <input type="text" class="form-control" id="articleContent" placeholder="Konten Artikel">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="articleCover">Sampul</label>
                            <input type="image" class="form-control" id="articleCover" placeholder="sampul">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-confirm-update-article">Update</button>
                <button type="button" class="btn btn-primary btn-confirm-add-article">Tambah</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- CRUD Modal Dokumen -->
<div class="modal fade" id="crudModalDocArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Dokumen <span
                        class="document-article-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row upload--article">
                        <div class="form-group col-12">
                            <label>File Artikel</label>
                            <input id="article" type="file" accept=".pdf, .docx, .doc">
                        </div>
                        <div class="form-group col-12 text-right btn--upload-file d-none">
                            <button type="button" class="btn btn-sm btn-secondary btn--upload-article">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
