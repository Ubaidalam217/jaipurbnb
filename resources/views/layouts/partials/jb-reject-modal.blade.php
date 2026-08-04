{{--
  Shared rejection dialog for the admin queue and detail pages.

  Uses a native <dialog>, so focus trapping, Esc-to-close and the
  backdrop come from the browser rather than hand-rolled JS. Any button
  carrying data-jb-reject="<post-url>" opens it and retargets the form.
--}}
<dialog class="jb-modal" id="jb-reject-dialog" aria-labelledby="jb-reject-title">
  <form method="POST" id="jb-reject-form" class="jb-modal__body">
    @csrf
    <h2 id="jb-reject-title">Reject listing</h2>
    <p id="jb-reject-sub">This listing will be sent back to the host.</p>

    <div class="jb-auth__field">
      <label class="jb-auth__label" for="rejection_reason">Reason for rejection</label>
      <textarea class="jb-auth__input" id="rejection_reason" name="rejection_reason"
                maxlength="1000" style="min-height:110px;"
                placeholder="e.g. Photos need better quality"></textarea>
      <span class="jb-auth__hint">Optional, but the host sees this - a clear reason saves a round trip.</span>
    </div>

    <div class="jb-form__actions">
      <button class="jb-dash__cta" type="submit" style="background:#B3261E;">Reject listing</button>
      <button class="jb-dash__ghost" type="button" data-jb-close>Cancel</button>
    </div>
  </form>
</dialog>

<script>
  (function () {
    var dialog = document.getElementById('jb-reject-dialog');
    var form = document.getElementById('jb-reject-form');
    var sub = document.getElementById('jb-reject-sub');
    if (!dialog || !form) return;

    document.querySelectorAll('[data-jb-reject]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        form.action = btn.getAttribute('data-jb-reject');
        var title = btn.getAttribute('data-jb-title');
        if (sub && title) sub.textContent = '“' + title + '” will be sent back to the host.';
        if (typeof dialog.showModal === 'function') {
          dialog.showModal();
        } else {
          form.submit(); // very old browser fallback: reject with no reason
        }
      });
    });

    dialog.querySelectorAll('[data-jb-close]').forEach(function (b) {
      b.addEventListener('click', function () { dialog.close(); });
    });
  })();
</script>
