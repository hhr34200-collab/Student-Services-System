@extends('layouts.admin')

@section('title', 'إدارة الطلبات النشطة')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/requests.css') }}">
@endsection

@section('content')

    <!-- تمرير رسائل النظام لـ SweetAlert الخارجي -->
    <script>
        @if(session('success')) window.successMessage = "{{ session('success') }}"; @endif
        @if(session('error')) window.errorMessage = "{{ session('error') }}"; @endif
    </script>

    <div class="header">
        <h1><i class="fas fa-folder-open"></i> إدارة الطلبات النشطة</h1>
        <p>متابعة الطلبات الجارية داخل النظام والإشراف على سيرها بين الجهات المختصة حتى اكتمال إجراءاتها.</p>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="statistics-grid">
        <!-- الطلبات النشطة -->
        <div class="stat-card" data-filter="all">
            <div class="stat-info">
                <span>الطلبات النشطة</span>
                <h2>{{ $requests->count() }}</h2>
            </div>
            <div class="stat-icon blue">
                <i class="fas fa-folder-open"></i>
            </div>
        </div>

        <!-- قيد المراجعة -->
        <div class="stat-card" data-filter="review">
            <div class="stat-info">
                <span>قيد المراجعة</span>
                <h2>{{ $requests->whereIn('status', [
                    'student_affairs_review',
                    'department_head_review',
                    'dean_review'
                ])->count() }}</h2>
            </div>
            <div class="stat-icon orange">
                <i class="fas fa-spinner"></i>
            </div>
        </div>

        <!-- استكمال المرفقات -->
        <div class="stat-card" data-filter="attachments_required">
            <div class="stat-info">
                <span>استكمال المرفقات</span>
                <h2>{{ $requests->where('status', 'attachments_required')->count() }}</h2>
            </div>
            <div class="stat-icon purple">
                <i class="fas fa-paperclip"></i>
            </div>
        </div>

        <!-- الطلبات المتأخرة -->
        <div class="stat-card" data-filter="delayed">
            <div class="stat-info">
                <span>الطلبات المتأخرة</span>
                <h2>{{ $requests->where('created_at', '<', now()->subDays(3))->count() }}</h2>
            </div>
            <div class="stat-icon red">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- شريط البحث والإجمالي -->
    <div class="top-bar">
        <form method="GET" action="{{ route('requests.index') }}" id="mainSearchForm">
            <input class="search" type="text" name="search" id="mainSearchInput" value="{{ request('search') }}" placeholder="بحث فوري برقم الطلب أو اسم الطالب أو الخدمة...">
        </form>
        <div class="card">
            <strong>إجمالي الطلبات: {{ $requests->count() }}</strong>
        </div>
    </div>

    <!-- أزرار الفلتر (التبويبات) -->
    <div class="filter-tabs">
        <button class="filter-btn active" data-filter="all">الكل</button>
        <button class="filter-btn" data-filter="submitted">جديد</button>
        <button class="filter-btn" data-filter="review">قيد المراجعة</button>
        <button class="filter-btn" data-filter="attachments_required">استكمال مرفقات</button>
        <button class="filter-btn" data-filter="returned">معاد للطالب</button>
        <button class="filter-btn" data-filter="on_hold">معلق</button>
    </div>

    <!-- عرض الأخطاء إن وجدت -->
    @if ($errors->any())
        <div class="error-container">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- جدول الطلبات -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th>الطالب</th>
                    <th>الخدمة</th>
                    <th>الموظف الحالي</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody id="requests-table">
                @forelse($requests as $request)
                    @php
                        $statusClass = '';
                        $statusText = '';
                        $statusFilter = '';

                        switch($request->status){
                            case 'submitted':
                                $statusClass = 'submitted';
                                $statusText = 'جديد';
                                $statusFilter = 'submitted';
                                break;
                            case 'student_affairs_review':
                                $statusClass = 'review';
                                $statusText = 'شؤون الطلاب';
                                $statusFilter = 'review';
                                break;
                            case 'department_head_review':
                                $statusClass = 'review';
                                $statusText = 'رئيس القسم';
                                $statusFilter = 'review';
                                break;
                            case 'dean_review':
                                $statusClass = 'review';
                                $statusText = 'العميد';
                                $statusFilter = 'review';
                                break;
                            case 'attachments_required':
                                $statusClass = 'warning';
                                $statusText = 'استكمال مرفقات';
                                $statusFilter = 'attachments_required';
                                break;
                            case 'returned':
                                $statusClass = 'returned';
                                $statusText = 'معاد للطالب';
                                $statusFilter = 'returned';
                                break;
                            case 'on_hold':
                                $statusClass = 'hold';
                                $statusText = 'معلق';
                                $statusFilter = 'on_hold';
                                break;
                            default:
                                $statusClass = 'submitted';
                                $statusText = $request->status;
                                $statusFilter = 'submitted';
                        }
                    @endphp
                    <tr class="request-row" data-status="{{ $statusFilter }}">
                        <td>{{ $loop->iteration }}</td>
                        <td><strong class="request-number">{{ $request->request_number }}</strong></td>
                        <td>
                            <div class="student-cell">
                                <i class="fas fa-user-graduate"></i>
                                {{ $request->student->full_name ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <span class="service-badge">
                                {{ $request->service->service_name ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="employee-cell">
                                <i class="fas fa-user-tie"></i>
                               {{ $request->currentEmployee->full_name ?? 'غير محدد' }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <button class="action-icon view-btn" onclick="openRequestModal('{{ $request->request_id }}')" title="معاينة الطلب">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <h3>لا توجد طلبات نشطة</h3>
                                <p>جميع الطلبات الحالية منتهية أو تم نقلها إلى الأرشيف.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ========================================== -->
    <!-- مودال معاينة الطلب -->
    <!-- ========================================== -->
    <div class="modal" id="requestModal">
        <div class="modal-content">
            <!-- زر الإغلاق في أقصى اليسار -->
            
            
            <div class="modal-header">
                <div>
                    <h2><i class="fas fa-file-alt"></i> معلومات الطلب</h2>
                    <p>متابعة حالة الطلب الحالية داخل النظام.</p>
                </div>
            </div>

            <!-- البيانات الأساسية -->
            <div class="details-grid">
                <div class="info-item">
                    <label>رقم الطلب</label>
                    <div class="value" id="modalRequestNumber">-</div>
                </div>
                <div class="info-item">
                    <label>الطالب</label>
                    <div class="value" id="modalStudent">-</div>
                </div>
                <div class="info-item">
                    <label>الخدمة</label>
                    <div class="value" id="modalService">-</div>
                </div>
                <div class="info-item">
                    <label>الموظف الحالي</label>
                    <div class="value" id="modalEmployee">-</div>
                </div>
            </div>

            <!-- الحالة الحالية -->
            <div class="status-box">
                <label>الحالة الحالية</label>
                <div id="modalStatus" class="status-large">-</div>
            </div>

            <!-- ملخص الطلب -->
            <div class="summary-box">
                <div class="summary-item">
                    <span>نوع الخدمة</span>
                    <strong id="summaryService">-</strong>
                </div>
                <div class="summary-item">
                    <span>الموظف المسؤول</span>
                    <strong id="summaryEmployee">-</strong>
                </div>
                <div class="summary-item">
                    <span>حالة الطلب</span>
                    <strong id="summaryStatus">-</strong>
                </div>
            </div>

            <!-- مسار سير الطلب -->
            <div class="workflow-section">
                <h4><i class="fas fa-route"></i> مسار الطلب</h4>
                <div class="workflow-timeline">
                    <div class="workflow-step" id="step-submitted">
                        <div class="step-circle"><i class="fas fa-file-alt"></i></div>
                        <span>إنشاء الطلب</span>
                    </div>
                    <div class="workflow-line"></div>
                    <div class="workflow-step" id="step-affairs">
                        <div class="step-circle"><i class="fas fa-user-check"></i></div>
                        <span>شؤون الطلاب</span>
                    </div>
                    <div class="workflow-line"></div>
                    <div class="workflow-step" id="step-department">
                        <div class="step-circle"><i class="fas fa-users"></i></div>
                        <span>رئيس القسم</span>
                    </div>
                    <div class="workflow-line"></div>
                    <div class="workflow-step" id="step-dean">
                        <div class="step-circle"><i class="fas fa-university"></i></div>
                        <span>العميد</span>
                    </div>
                    <div class="workflow-line"></div>
                    <div class="workflow-step" id="step-approved">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <span>الأرشيف</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-close-modal" onclick="closeRequestModal()">
                    <i class="fas fa-times"></i> إغلاق
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/requests.js') }}"></script>
@endsection