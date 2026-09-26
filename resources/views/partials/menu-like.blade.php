@php
    $likeCount = (int) ($menu->likes_count ?? 0);
    $isLiked = in_array((int) $menu->id, array_map('intval', $likedIds ?? []), true);
@endphp

@once
    <style>
        .dw-like-icon { font-variation-settings: 'FILL' 0; transition: transform .15s ease; }
        .dw-like-btn:hover { color: #e11d48; border-color: #fecdd3; }
        .dw-like-btn:hover .dw-like-icon { font-variation-settings: 'FILL' 1; }
        .dw-like-btn:active .dw-like-icon { transform: scale(1.3); }
        .dw-like-btn[aria-pressed='true'] { color: #e11d48; border-color: #fecdd3; background-color: #fff1f2; }
        .dw-like-btn[aria-pressed='true'] .dw-like-icon { font-variation-settings: 'FILL' 1; }
        .dw-like-btn[disabled] { opacity: .6; }
    </style>
    <script>
        document.addEventListener('submit', async function (event) {
            var form = event.target.closest('[data-like-form]');
            if (!form) {
                return;
            }

            event.preventDefault();

            var button = form.querySelector('[data-like-button]');
            var countEl = form.querySelector('[data-like-count]');
            var tokenField = form.querySelector('input[name="_token"]');
            var wasLiked = button.getAttribute('aria-pressed') === 'true';
            var previousCount = parseInt(countEl.textContent, 10) || 0;

            button.disabled = true;
            button.setAttribute('aria-pressed', wasLiked ? 'false' : 'true');
            countEl.textContent = wasLiked ? Math.max(previousCount - 1, 0) : previousCount + 1;

            try {
                var response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': tokenField ? tokenField.value : ''
                    },
                    body: new FormData(form)
                });

                if (!response.ok) {
                    throw new Error('Gagal menyimpan suka.');
                }

                var data = await response.json();
                button.setAttribute('aria-pressed', data.liked ? 'true' : 'false');
                countEl.textContent = data.count;
            } catch (error) {
                button.setAttribute('aria-pressed', wasLiked ? 'true' : 'false');
                countEl.textContent = previousCount;
            } finally {
                button.disabled = false;
            }
        });
    </script>
@endonce

<form method="POST" action="{{ route('menus.like', $menu) }}" data-like-form>
    @csrf
    <button type="submit" data-like-button aria-pressed="{{ $isLiked ? 'true' : 'false' }}"
            title="{{ $isLiked ? 'Batalkan suka pada menu ini' : 'Sukai menu ini' }}"
            class="dw-like-btn press-anim inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-slate-500 transition-colors">
        <span class="material-symbols-outlined dw-like-icon text-base">favorite</span>
        <span data-like-count>{{ $likeCount }}</span>
        <span class="sr-only">suka</span>
    </button>
</form>
