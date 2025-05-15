<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Finalización</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .certificate {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border: 20px solid #f8a100;
            position: relative;
            background-color: #fff;
        }
        .certificate:after {
            content: '';
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            border: 2px solid #333;
            z-index: -1;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 36px;
            color: #f8a100;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .subheader {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }
        .content {
            text-align: center;
            margin: 40px 0;
        }
        .student-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            border-bottom: 2px solid #f8a100;
            display: inline-block;
            padding-bottom: 5px;
        }
        .course-title {
            font-size: 22px;
            margin: 20px 0;
        }
        .date {
            font-size: 16px;
            margin: 30px 0;
        }
        .signature {
            margin-top: 60px;
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin: 0 auto;
            padding-top: 10px;
        }
        .signature-name {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .certificate-id {
            font-size: 10px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>Certificado de Finalización</h1>
            <div class="subheader">Este certificado se otorga a:</div>
        </div>
        
        <div class="content">
            <div class="student-name">{{ $user->name }}</div>
            
            <p>Por haber completado satisfactoriamente el curso:</p>
            
            <div class="course-title">{{ $course->title }}</div>
            
            <div class="date">Fecha de finalización: {{ $date }}</div>
        </div>
        
        <div class="signature">
            <div class="signature-line"></div>
            <div class="signature-name">David Martinez</div>
            <div>Instructor del curso</div>
        </div>
        
        <div class="footer">
            <p>Este certificado verifica que el estudiante ha completado todos los módulos y requisitos del curso.</p>
            <div class="certificate-id">ID de Certificado: {{ $certificate_id }}</div>
        </div>
    </div>
</body>
</html>