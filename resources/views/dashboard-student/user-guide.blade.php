@extends('layouts.app')

@section('title', 'دليل المستخدم')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user-guide.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
@endpush

@section('content')

<!-- شريط التقدم الذهبي أعلى الصفحة -->
<div id="scroll-progress"></div>

<div class="guide-container">
    
    <!-- القسم الأول: بطاقة الترحيب والإحصائيات -->
    <header class="premium-hero-card">
        <div class="hero-accent-line"></div>
        <div class="hero-main-content">
            <div class="hero-icon-wrapper">
                <i class="fas fa-book-open-reader"></i>
            </div>
            <h1>دليل المستخدم</h1>
            <p>مرحباً بك في دليل استخدام نظام الخدمات الطلابية. يهدف هذا الدليل إلى مساعدتك في التعرف على آلية استخدام النظام، وطريقة تقديم الطلبات الإلكترونية، ومتابعة مراحل معالجتها، مع توضيح الشروط والتعليمات الخاصة بكل خدمة.</p>
        </div>
        
        <div class="premium-stats-bar">
            <div class="stat-item">
                <i class="fas fa-layer-group"></i>
                <div class="stat-numbers">
                    <h3 data-target="8">0</h3>
                    <span>أقسام الدليل</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <i class="fas fa-graduation-cap"></i>
                <div class="stat-numbers">
                    <h3 data-target="3">0</h3>
                    <span>الخدمات الإلكترونية</span>
                </div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <i class="fas fa-list-check"></i>
                <div class="stat-numbers">
                    <h3 data-target="25">0</h3>
                    <span>إرشاداً وتنبنهاً</span>
                </div>
            </div>
        </div>
    </header>

    <!-- قائمة البطاقات الطولية بعرض كامل Full-Width -->
    <main class="premium-guide-wrapper">
        
        <!-- القسم الثاني: آلية استخدام النظام -->
        <div class="premium-card" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box blue-zone"><i class="fas fa-laptop-code"></i></div>
                    <div class="title-sub">
                        <h3>آلية استخدام النظام الإلكتروني</h3>
                        <p>دورة الاستخدام المباشرة للخدمات من تسجيل الدخول وحتى الإرسال.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="tabs-divider"><span><i class="fas fa-circle-info"></i> نبذة عن النظام</span></div>
                <p class="pane-desc">يوفر النظام خدمات أكاديمية إلكترونية تمكن الطالب من تقديم الطلبات ومتابعتها حتى صدور القرار النهائي دون الحاجة إلى مراجعة الجهات المختصة إلا عند الضرورة.</p>
                
                <div class="tabs-divider"><span><i class="fas fa-route"></i> الخط الزمني للاستخدام</span></div>
                <div class="premium-horizontal-timeline">
                    <div class="timeline-node"><div class="node-circle active-node"><i class="fas fa-right-to-bracket"></i></div><span>تسجيل الدخول</span></div>
                    <div class="timeline-line"></div>
                    <div class="timeline-node"><div class="node-circle"><i class="fas fa-list-check"></i></div><span>اختيار الخدمة</span></div>
                    <div class="timeline-line"></div>
                    <div class="timeline-node"><div class="node-circle"><i class="fas fa-pen-to-square"></i></div><span>تعبئة البيانات</span></div>
                    <div class="timeline-line"></div>
                    <div class="timeline-node"><div class="node-circle"><i class="fas fa-paperclip"></i></div><span>رفع المرفقات</span></div>
                    <div class="timeline-line"></div>
                    <div class="timeline-node"><div class="node-circle"><i class="fas fa-paper-plane"></i></div><span>إرسال الطلب</span></div>
                    <div class="timeline-line"></div>
                    <div class="timeline-node"><div class="node-circle"><i class="fas fa-eye"></i></div><span>متابعة الطلب</span></div>
                </div>
                
                <div class="custom-alert info-alert">
                    <i class="fas fa-circle-info"></i>
                    <span>تأكد من صحة البيانات قبل إرسال الطلب، لأن بعض الخدمات لا تسمح بتعديل الطلب بعد إرساله.</span>
                </div>
            </div>
        </div>

        <!-- القسم الثالث: الخدمات الإلكترونية المتاحة -->
        <div class="premium-card" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box green-zone"><i class="fas fa-graduation-cap"></i></div>
                    <div class="title-sub">
                        <h3>الخدمات الإلكترونية المتاحة</h3>
                        <p>الشروط والمعايير الأكاديمية الخاصة بطلبات وقف القيد، إعادة القيد، والتظلمات.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                
                <!-- خدمة 1 -->
                <div class="tabs-divider"><span><i class="fas fa-hand-lines-slash"></i> 1. خدمة وقف القيد</span></div>
                <p class="pane-desc">تتيح للطالب إيقاف الدراسة مؤقتًا وفق اللوائح الجامعية المعتمدة وبما لا يتعارض مع الخطة الدراسية.</p>
                <ul class="premium-steps-list">
                    <li>أن يكون الطالب قد أنهى السنة الدراسية الأولى بنجاح.</li>
                    <li>ألا يكون الطالب موقوف القيد حالياً في النظام.</li>
                    <li>عدم وجود طلب وقف قيد سابق قيد المراجعة أو معتمد في نفس الفصل.</li>
                    <li>استيفاء البيانات والمبررات المطلوبة في نموذج التقديم.</li>
                </ul>

                <!-- خدمة 2 -->
                <div class="tabs-divider"><span><i class="fas fa-rotate-left"></i> 2. خدمة إعادة القيد</span></div>
                <p class="pane-desc">تُستخدم لطلب عودة الطالب المقيد إلى مقاعد الدراسة بعد انتهاء فترة وقف القيد المعتمدة له.</p>
                <ul class="premium-steps-list">
                    <li>أن تكون حالة الطالب الحالية في النظام هي (موقف قيد).</li>
                    <li>وجود طلب وقف قيد سابق معتمد ومنتهي الصلاحية.</li>
                    <li>ألا تتجاوز مدة انقطاع الطالب عن الدراسة سنتين دراسيتين.</li>
                    <li>عدم وجود طلب إعادة قيد سابق قيد المراجعة حالياً.</li>
                </ul>

                <!-- خدمة 3 -->
                <div class="tabs-divider"><span><i class="fas fa-scale-balanced"></i> 3. خدمة التظلم الأكاديمي</span></div>
                <p class="pane-desc">تمكن الطالب من الاعتراض رسميًا على نتيجة مقرر دراسي محدد ومراجعة كراسة الإجابة.</p>
                <ul class="premium-steps-list">
                    <li>اختيار المقرر الدراسي المطلوب التظلم منه بدقة من قائمة المقررات المسجلة.</li>
                    <li>كتابة سبب التظلم بوضوح وموضوعية في الحقل المخصص.</li>
                    <li>إرفاق المستندات الداعمة لوجهة نظر الطالب إن وجدت.</li>
                </ul>
            </div>
        </div>

        <!-- القسم الرابع: رفع المرفقات والمستندات -->
        <div class="premium-card" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box orange-zone"><i class="fas fa-file-arrow-up"></i></div>
                    <div class="title-sub">
                        <h3>إرفاق المستندات الرسمية</h3>
                        <p>صيغ الملفات المدعومة والتعليمات الفنية لضمان سرعة فحص الملفات.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="tabs-divider"><span><i class="fas fa-file-shield"></i> الملفات المقبولة نظاماً</span></div>
                <div class="premium-formats-badges">
                    <span>PDF</span><span>JPG</span><span>JPEG</span><span>PNG</span><span>DOC</span><span>DOCX</span>
                </div>
                
                <div class="tabs-divider"><span><i class="fas fa-clipboard-check"></i> تعليمات الرفع الفنية</span></div>
                <ul class="premium-steps-list">
                   
                    <li>يجب أن تكون الملفات والمستندات الممسوحة ضوئياً واضحة ومقروءة تماماً.</li>
                    <li>يفضل دمج المستندات المتعددة المتعلقة بالطلب في ملف PDF واحد.</li>
                    <li>تجنب رفع ملفات عشوائية أو لا تخص الخدمة المحددة لتفادي الرفض الفوري.</li>
                </ul>
            </div>
        </div>

        <!-- القسم الخامس: مسار متابعة الطلب -->
        <div class="premium-card" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box purple-zone"><i class="fas fa-diagram-next"></i></div>
                    <div class="title-sub">
                        <h3>مسار معالجة ومتابعة الطلب</h3>
                        <p>المراحل الإدارية والأكاديمية التي يمر بها طلبك الإلكتروني داخل النظام.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="tabs-divider"><span><i class="fas fa-sitemap"></i> المراحل الإدارية للطلب</span></div>
                
                <div class="vertical-chain-flow">
                    <div class="chain-item"><i class="fas fa-circle-dot blue-t"></i> <strong>تقديم الطلب:</strong> يقوم الطالب بإنشاء وإرسال المعاملة بنجاح.</div>
                    <div class="chain-item"><i class="fas fa-circle-dot blue-t"></i> <strong>موظف شؤون الطلاب:</strong> مراجعة الطلب الأولية والتحقق من المرفقات والشروط.</div>
                    <div class="chain-item"><i class="fas fa-circle-dot blue-t"></i> <strong>رئيس القسم الأكاديمي:</strong> دراسة الطلب وإبداء الرأي التخصصي أو التوصية.</div>
                    <div class="chain-item"><i class="fas fa-circle-dot blue-t"></i> <strong>عميد الكلية:</strong> المراجعة النهائية واعتماد القرار الرسمي.</div>
                    <div class="chain-item"><i class="fas fa-circle-dot gold-t"></i> <strong>اعتماد أو رفض الطلب:</strong> تسجيل القرار النهائي رسمياً على النظام.</div>
                    <div class="chain-item"><i class="fas fa-circle-dot green-t"></i> <strong>إشعار الطالب:</strong> تحديث حالة الطلب وإرسال التنبيه التلقائي للطالب.</div>
                </div>

                <div class="custom-alert info-alert">
                    <i class="fas fa-lightbulb"></i>
                    <span>يمكن متابعة المرحلة الحالية من خلال صفحة "طلباتي"، كما تصل إشعارات تلقائية فورية عند انتقال الطلب من مرحلة إلى أخرى.</span>
                </div>
            </div>
        </div>

        <!-- القسم السادس: استكمال المرفقات (الميزة الجديدة المبرزة) -->
        <div class="premium-card border-orange-left shadow-highlight" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box orange-glow-zone"><i class="fas fa-rotate"></i></div>
                    <div class="title-sub">
                        <h3>استكمال المرفقات المطلوبة <span class="badge-new">ميزة جديدة</span></h3>
                        <p>دليلك للتعامل مع الطلبات المعاد تصحيحها بسبب نواقص أو عدم وضوح في المرفقات.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="tabs-divider"><span><i class="fas fa-question-block"></i> ماذا تعني هذه الحالة؟</span></div>
                <p class="pane-desc">إذا لاحظ الموظف المختص أثناء مراجعة طلبك أن بعض المرفقات ناقصة أو غير واضحة، <strong>فلن يتم رفض الطلب مباشرة</strong>، بل يتم تحويله إلى حالة <span class="txt-orange">"استكمال المرفقات المطلوبة"</span> لمنحك فرصة تعديل النواقص ودون الحاجة لتقديم طلب جديد بالكامل.</p>
                
                <div class="feature-flow-grid">
                    <div class="flow-box">
                        <h5><i class="fas fa-user-gear"></i> إجراءات النظام والموظف</h5>
                        <ul class="sub-list">
                            <li>مراجعة الطلب بدقة وتحديد النواقص.</li>
                            <li>كتابة ملاحظة تفصيلية تظهر للطالب.</li>
                            <li>تحديد وتسمية الملفات البديلة المطلوبة.</li>
                            <li>تغيير حالة الطلب وإرسال تنبيه فوري للطالب.</li>
                        </ul>
                    </div>
                    <div class="flow-box">
                        <h5><i class="fas fa-user-grad"></i> دور الطالب وما يجب عمله</h5>
                        <ul class="sub-list">
                            <li>الدخول المباشر إلى صفحة <strong>"طلباتي"</strong>.</li>
                            <li>العثور على الحالة البرتقالية المخصصة: <br><span class="badge-orange-status">🟠 استكمال المرفقات المطلوبة</span></li>
                            <li>الضغط على زر <strong>"عرض واستكمال المرفقات"</strong>.</li>
                        </ul>
                    </div>
                </div>

                <div class="tabs-divider"><span><i class="fas fa-window-restore"></i> محتويات صفحة الاستكمال</span></div>
                <p class="pane-desc">عند دخولك لصفحة التعديل، ستظهر لك واجهة مخصصة تحتوي على: بياناتك وبيانات الطلب الأساسية، <strong>ملاحظات الموظف الدقيقة</strong> لمعرفة الخلل، المرفقات الحالية المعيبة، وقسم جديد مخصص ومحمي لرفع الملفات البديلة ثم زر <strong>"إرسال المرفقات"</strong>.</p>

                <div class="custom-alert success-alert">
                    <i class="fas fa-circle-check"></i>
                    <span>بمجرد رفع الملفات المطلوبة وضغط إرسال، يعود الطلب تلقائياً إلى مسار المراجعة السابق لاستكمال بقية إجراءات الاعتماد.</span>
                </div>
            </div>
        </div>

        <!-- القسم السابع: التنبيهات والتعليمات العامة -->
        <div class="premium-card border-gold-left" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box gold-zone"><i class="fas fa-triangle-exclamation"></i></div>
                    <div class="title-sub">
                        <h3>تعليمات وقواعد أكاديمية يجب مراعاتها</h3>
                        <p>القواعد القانونية المنظمة لضمان حماية المعاملات وسيرها بالشكل السليم.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="tabs-divider"><span><i class="fas fa-shield-exclamation"></i> إرشادات الأمان والالتزام</span></div>
                <div class="premium-grid-alerts">
                    <div class="alert-grid-item"><i class="fas fa-circle-check"></i> التأكد التام من صحة كافة البيانات الأكاديمية والشخصية قبل تأكيد الإرسال.</div>
                    <div class="alert-grid-item"><i class="fas fa-circle-check"></i> وجوب قراءة شروط وأحكام كل خدمة أكاديمية بعناية قبل التقديم عليها.</div>
                    <div class="alert-grid-item"><i class="fas fa-circle-check"></i> لا يمكن تعديل الطلب نهائياً بعد الإرسال إلا إذا أُعيد لك في حالة (استكمال المرفقات).</div>
                    <div class="alert-grid-item"><i class="fas fa-circle-check"></i> متابعة لوحة الإشعارات والبريد الجامعي باستمرار لمعرفة المستجدات أولاً بأول.</div>
                    <div class="alert-grid-item"><i class="fas fa-circle-check"></i> ضرورة الاحتفاظ بالمستندات الأصلية الورقية حتى انتهاء المعاملة تماماً وصدور القرار.</div>
                </div>
            </div>
        </div>

        <!-- القسم الثامن: الأسئلة الشائعة FAQ -->
        <div class="premium-card" onclick="toggleCard(this)">
            <div class="card-header-main">
                <div class="card-branding">
                    <div class="icon-box red-zone"><i class="fas fa-circle-question"></i></div>
                    <div class="title-sub">
                        <h3>الأسئلة الشائعة (FAQ)</h3>
                        <p>إجابات سريعة وحلول فورية لأكثر الاستفسارات تكراراً بين الطلاب.</p>
                    </div>
                </div>
                <div class="arrow-trigger"><i class="fas fa-chevron-down"></i></div>
            </div>
            <div class="card-content-pane">
                <div class="faq-premium-box">
                    <h4><i class="far fa-comments"></i> كيف أتابع حالة طلبي الإلكتروني؟</h4>
                    <p>من خلال لوحة التحكم الخاصة بك، انتقل إلى صفحة "طلباتي" حيث يظهر لك جدول زمني حي يوضح المرحلة الحالية التي تقف عندها المعاملة.</p>
                </div>
                <div class="faq-premium-box">
                    <h4><i class="far fa-comments"></i> هل يمكن تقديم أكثر من طلب لنفس الخدمة؟</h4>
                    <p>لا يسمح النظام بإنشاء طلب جديد لنفس الخدمة إذا كان هناك طلب سابق لها لا يزال (قيد المراجعة) أو (تحت الدراسة) لتجنب التكرار.</p>
                </div>
                <div class="faq-premium-box">
                    <h4><i class="far fa-comments"></i> هل يمكنني تعديل بيانات الطلب بعد إرساله؟</h4>
                    <p>لا، بمجرد الضغط على إرسال يدخل الطلب في المسار القانوني ولا يمكن تعديله إلا إذا قام الموظف بتغيير حالته إلى "طلب استكمال المرفقات".</p>
                </div>
                <div class="faq-premium-box">
                    <h4><i class="far fa-comments"></i> ماذا أفعل إذا تحولت حالة طلبي إلى "استكمال المرفقات"؟</h4>
                    <p>كل ما عليك هو فتح تفاصيل الطلب من صفحة "طلباتي"، وقراءة ملاحظة الموظف، ثم إعادة رفع الملفات الناقصة أو الواضحة وضغط إرسال المرفقات.</p>
                </div>
                <div class="faq-premium-box">
                    <h4><i class="far fa-comments"></i> كيف يمكنني معرفة أسباب رفض الطلب في حال تم ذلك؟</h4>
                    <p>عند رفض أي طلب (لا قدر الله)، يلتزم الموظف أو صاحب الصلاحية بكتابة مبرر الرفض الأكاديمي، والذي يظهر لك مباشرة في صفحة تفاصيل الطلب بجانب إشعار الرفض.</p>
                </div>
            </div>
        </div>

    </main>
</div>

<!-- زر العودة للأعلى الذكي -->
<button id="scroll-to-top" class="scroll-top-btn"><i class="fas fa-arrow-up"></i></button>

<script src="{{ asset('js/user-guide.js') }}"></script>
@endsection