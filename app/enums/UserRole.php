<?php

namespace App\enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super-admin';
    case SCHOOL_ADMIN = 'school-admin';
    case GUARDIAN = 'guardian';
    case CLASS_TEACHER = 'class-teacher';
    case SUBJECT_TEACHER = 'subject-teacher';
    case SCHOOL_HEAD   = 'school-head';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case ACCOUNT_ADMIN = 'account-admin';
    case BURSAR = 'bursar';
}
