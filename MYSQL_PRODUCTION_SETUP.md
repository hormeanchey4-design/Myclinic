# MySQL Production User Setup

Do not use `root` for the app in production.

## 1. Create database

```sql
CREATE DATABASE clinic_system
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

## 2. Create dedicated DB user

```sql
CREATE USER 'clinic_user'@'localhost' IDENTIFIED BY 'CHANGE_THIS_STRONG_PASSWORD';
```

If app and DB are on different servers, restrict host accordingly (not `%` unless required):

```sql
CREATE USER 'clinic_user'@'10.10.10.20' IDENTIFIED BY 'CHANGE_THIS_STRONG_PASSWORD';
```

## 3. Grant least required privileges

```sql
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX
ON clinic_system.* TO 'clinic_user'@'localhost';
FLUSH PRIVILEGES;
```

## 4. Import schema

```bash
mysql -u clinic_user -p clinic_system < database.sql
```

## 5. Set environment variables

- `DB_HOST=localhost`
- `DB_USER=clinic_user`
- `DB_PASS=CHANGE_THIS_STRONG_PASSWORD`
- `DB_NAME=clinic_system`
- `APP_BASE_URL=https://your-domain.com/clinic_system/`

## 6. Post-deploy

- Change demo account passwords immediately.
- Back up DB daily.
- Rotate DB password periodically.

