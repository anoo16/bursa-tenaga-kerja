<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Google Berhasil</title>
</head>
<body>

    <script>
        const params = new URLSearchParams(window.location.search);

        const token = params.get('token');

        if (!token) {
            window.location.href = '/login';
        }

        localStorage.setItem('token', token);

        fetch('/api/auth/me', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(result => {
            if (!result.success) {
                localStorage.removeItem('token');
                window.location.href = '/login';
                return;
            }

            const user = result.data;

            localStorage.setItem('user', JSON.stringify(user));

            if (user.role_id == 1) {
                window.location.href = '/dashboard/admin';
            } else if (user.role_id == 2) {
                window.location.href = '/dashboard/recruiter';
            } else {
                window.location.href = '/dashboard/jobseeker';
            }
        })
        .catch(() => {
            localStorage.removeItem('token');
            window.location.href = '/login';
        });
    </script>

</body>
</html>