<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header { background: #1a1f2e; color: #fff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 1.4rem; }
        .header span { color: #4e9af1; }
        .body { padding: 30px; }
        .body h2 { color: #1a1f2e; font-size: 1.1rem; }
        .info-box { background: #f8fafc; border-left: 4px solid #4e9af1; border-radius: 8px; padding: 16px; margin: 20px 0; }
        .info-box p { margin: 6px 0; color: #4a5568; font-size: 0.95rem; }
        .info-box strong { color: #1a1f2e; }
        .badge { display: inline-block; background: #ffc107; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }
        .footer { background: #f8fafc; text-align: center; padding: 16px; font-size: 0.8rem; color: #a0aec0; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 Cabinet <span>Médical</span></h1>
        </div>
        <div class="body">
            <h2>Bonjour {{ $appointment->patient->name }},</h2>
            <p>Votre rendez-vous a été enregistré avec succès. Voici les détails :</p>

            <div class="info-box">
                <p><strong>👨‍⚕️ Médecin :</strong> {{ $appointment->medecin->name }}</p>
                <p><strong>🏥 Service :</strong> {{ $appointment->service->name }}</p>
                <p><strong>📅 Date :</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y à H:i') }}</p>
                <p><strong>📋 Statut :</strong> <span class="badge">En attente</span></p>
                @if($appointment->notes)
                <p><strong>📝 Notes :</strong> {{ $appointment->notes }}</p>
                @endif
            </div>

            <p>Merci de vous présenter 10 minutes avant votre rendez-vous.</p>
            <p>Cordialement,<br><strong>L'équipe du Cabinet Médical</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Cabinet Médical — Tous droits réservés
        </div>
    </div>
</body>
</html>