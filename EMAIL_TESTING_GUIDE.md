# Email Verification Testing Quick Reference

## Testing Tools Available

### 1. **Artisan Command** ✅ (Primary Method)
Most direct and reliable way to test email verification

```bash
# Test with Resend SMTP (limited to verified email)
php artisan test:email salhi45adam@gmail.com --reset

# Test with Log mailer (unlimited, stores in logs)
php artisan test:email anyemail@test.com --reset --mailer=log
```

**Output includes:**
- User creation/lookup
- Verification status
- **Verification URL** (ready to click/paste)
- Email send confirmation
- Duration in milliseconds

**Example Output:**
```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Email Verification Test: testuser@example.com
Mailer: log
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✓ User created (ID: 17)
✓ Email verification reset
✓ Email sent successfully (20.37ms)

Verification URL:
http://127.0.0.1:8001/api/auth/verify-email/17/HASH?signature=SIGNATURE
```

### 2. **HTML Dashboard**
Visual reference guide for testing

```
http://127.0.0.1:8001/email-testing.html
```

Features:
- Quick start guide
- Command reference
- Workflow steps
- Configuration examples

### 3. **Log Viewer**
Check email activity in logs

```bash
# View recent email-related logs
tail -50 storage/logs/laravel.log | grep -i "email\|verification"
```

---

## Testing Workflow

### Step 1: Run Test Command
```bash
php artisan test:email salhi45adam@gmail.com --reset
```

### Step 2: Get Verification URL from Output
The command prints the URL directly - copy it

### Step 3: Verify Email
Click or paste the URL in browser:
```
http://127.0.0.1:8001/api/auth/verify-email/14/...?signature=...
```

### Step 4: Confirm in Logs
Check laravel.log for "Email verified successfully" message

### Step 5: Login
Go to `/auth` and login with the test email and password `TestPassword123`

---

## Testing Multiple Emails

### Using Log Mailer (Recommended)
```bash
# Email 1
php artisan test:email user1@test.com --reset --mailer=log

# Email 2
php artisan test:email user2@test.com --reset --mailer=log

# Email 3
php artisan test:email user3@test.com --reset --mailer=log
```

### Using Resend SMTP
Limited to: `salhi45adam@gmail.com`

**To test with more emails:**
1. Go to https://resend.com/domains
2. Add and verify a custom domain
3. Update `.env`:
   ```
   MAIL_FROM_ADDRESS="noreply@yourdomain.com"
   ```
4. Now test with any email address

---

## Mailer Options

### SMTP (Resend.com) ✓ Production Ready
```bash
php artisan test:email salhi45adam@gmail.com --reset
# or
php artisan test:email salhi45adam@gmail.com --reset --mailer=smtp
```
**Pros:** Real email sending to Resend API  
**Cons:** Free tier limited to 1 verified address

### Log Mailer ✓ Development
```bash
php artisan test:email anyemail@test.com --reset --mailer=log
```
**Pros:** Works with any email, fast, stores in logs  
**Cons:** Not real email, development only

---

## Verifying Email Manually

If you need to verify an email without clicking the link:

```bash
php artisan tinker
```

```php
$user = App\Models\User::find(14);
$user->markEmailAsVerified();
```

---

## Troubleshooting

### "Email already verified"
The user's email is already verified. Use `--reset` flag:
```bash
php artisan test:email user@example.com --reset
```

### "Unsupported mail transport"
Make sure you're using a valid mailer (`smtp` or `log`):
```bash
php artisan test:email user@example.com --mailer=log
```

### "Expected response code 550"
Resend only allows emails to verified addresses in test tier. Use log mailer or verify a custom domain.

### Email not found in logs
Check file permissions on `storage/logs/`:
```bash
ls -la storage/logs/
tail -100 storage/logs/laravel.log
```

---

## Database Queries

### Find Test Users
```bash
php artisan tinker
```

```php
User::where('company', 'Test Company')->get();
User::where('name', 'like', 'Test User%')->get();
```

### Mark All Unverified
```php
User::whereNull('email_verified_at')->update(['email_verified_at' => now()]);
```

### Reset Verification
```php
$user = User::find(14);
$user->email_verified_at = null;
$user->save();
```

---

## Configuration Files

**Mail Config**: `config/mail.php`  
**Environment**: `.env`  
**Command**: `app/Console/Commands/TestEmailVerification.php`  
**Test Endpoints**: Routes defined in `routes/api.php` (prefix: `/api/debug/email/`)

---

## Recent Test Results

| Email | Method | User ID | Status | Notes |
|-------|--------|---------|--------|-------|
| salhi45adam@gmail.com | SMTP | 14 | ✅ Verified | Original test user |
| testuser2@example.com | Log | 17 | ✅ Verified | Created & verified successfully |
| testuser3@example.com | Log | 18 | ✅ Verified | Created & verified successfully |

---

## Tips & Tricks

**Generate Verification URL for Debugging:**
```bash
php artisan tinker
$user = User::find(14);
URL::signedRoute('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)])
```

**Check Mailer in Real-Time:**
```bash
tail -f storage/logs/laravel.log | grep "Email verification test"
```

**Create Test User Manually:**
```bash
php artisan tinker
User::create([
  'name' => 'Test',
  'email' => 'test@example.com',
  'password' => bcrypt('Test123!'),
  'company' => 'Test Company'
])
```

