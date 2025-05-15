@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">¡Felicidades! Has completado el curso</h2>
                </div>
                <div class="card-body">
                    <div class="certificate-container p-4 border border-3 border-success position-relative">
                        <div class="text-center mb-4">
                            <h1 class="display-4 mb-3">Certificado de Finalización</h1>
                            <p class="lead">Este certificado acredita que</p>
                            <h2 class="display-5 fw-bold text-primary mb-3">{{ $user->name }}</h2>
                            <p class="lead">ha completado satisfactoriamente el curso</p>
                            <h3 class="display-6 fw-bold text-success mb-4">{{ $course->title }}</h3>
                            
                            <div class="row mt-5">
                                <div class="col-md-6 text-md-end">
                                    <p>Fecha de finalización:</p>
                                    <p class="fw-bold">{{ $certificate->completion_date->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6 text-md-start">
                                    <p>Número de certificado:</p>
                                    <p class="fw-bold">{{ $certificate->certificate_number }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="certificate-seal position-absolute bottom-0 end-0 m-4">
                            <img src="{{ asset('images/seal.png') }}" alt="S