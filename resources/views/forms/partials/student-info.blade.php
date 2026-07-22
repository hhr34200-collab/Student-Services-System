<div class="student-section">

    <p class="official-text">

        <strong>أنا الطالب / الطالبة</strong>

        <span class="inline-field student-name">
            {{ $request->student->full_name }}
        </span>

        <strong>أحمل بطاقة جامعية برقم قيد</strong>

        <span class="inline-field">
            ({{ $request->student->student_number }})
        </span>
         <strong >في تخصص :</strong>

        <span class="inline-field">
            {{ $request->student->department->department_name }}
        </span>

        <strong>بالمستوى :</strong>

        <span class="inline-field">
            {{ $request->student->level }}
        </span>

        <strong>للعام الجامعي</strong>

        <span class="inline-field">
            {{ $request->stopEnrollment->academic_year }}
        </span>
         <strong> الموقع أدناه.</strong>

    </p>

</div>