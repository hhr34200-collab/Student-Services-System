<div class="attachments-section">

    <div class="attachments-title">

        المرفقــات:

    </div>

    @forelse($request->attachments as $attachment)

        <div class="attachment-item">

            <div class="attachment-name">

                <i class="fas fa-paperclip"></i>

                {{ $attachment->file_name }}

            </div>

            <a
                href="{{ route('attachment.download',$attachment->attachment_id) }}"
                target="_blank"
                class="attachment-link">

                فتح

            </a>

        </div>
        <div class="approval-divider">
        </div>
    

    @empty

        <div class="attachment-empty">

            لا توجد مرفقات.

        </div>
        <hr class="approval-divider">


</div>
    @endforelse

</div>