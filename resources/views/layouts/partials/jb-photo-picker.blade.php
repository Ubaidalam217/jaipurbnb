{{--
  Client-side photo picker used by the create/edit listing forms.

  Keeps its own array of File objects so a photo can be removed after
  selection, then rebuilds the input's FileList via DataTransfer - a
  plain <input type="file"> has no "remove one item" API.

  Radio semantics differ per form:
    create -> single group named "cover_index", value = array index
    edit   -> single group named "cover_choice" spanning existing AND
              new photos; a submit handler splits the winner into the
              hidden cover_image_id / cover_index fields.
--}}
<script>
  (function () {
    var input = document.getElementById('photos');
    var grid = document.getElementById('jb-previews');
    var count = document.getElementById('jb-photo-count');
    if (!input || !grid) return;

    var MAX = 15;
    var isEdit = document.body.hasAttribute('data-jb-edit');
    var coverName = isEdit ? 'cover_choice' : 'cover_index';
    var files = [];

    function syncInput() {
      var dt = new DataTransfer();
      files.forEach(function (f) { dt.items.add(f); });
      input.files = dt.files;
    }

    function existingKept() {
      return document.querySelectorAll('input[name="existing_image_ids[]"]:checked').length;
    }

    function render() {
      grid.innerHTML = '';

      files.forEach(function (file, i) {
        var card = document.createElement('div');
        card.className = 'jb-photo';

        var img = document.createElement('img');
        img.className = 'jb-photo__img';
        img.alt = file.name;
        img.src = URL.createObjectURL(file);
        img.onload = function () { URL.revokeObjectURL(img.src); };
        card.appendChild(img);

        var foot = document.createElement('div');
        foot.className = 'jb-photo__foot';

        var pick = document.createElement('label');
        pick.className = 'jb-photo__pick';
        var radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = coverName;
        radio.value = isEdit ? ('new:' + i) : String(i);
        radio.addEventListener('change', paintCover);
        pick.appendChild(radio);
        pick.appendChild(document.createTextNode('Cover'));
        foot.appendChild(pick);

        var del = document.createElement('button');
        del.type = 'button';
        del.className = 'jb-btn-sm jb-btn-sm--danger';
        del.style.minHeight = '32px';
        del.style.padding = '0 10px';
        del.textContent = 'Remove';
        del.addEventListener('click', function () {
          files.splice(i, 1);
          syncInput();
          render();
        });
        foot.appendChild(del);

        card.appendChild(foot);
        grid.appendChild(card);
      });

      // Default the cover to the first new photo when nothing is chosen.
      var chosen = document.querySelector('input[name="' + coverName + '"]:checked');
      if (!chosen && files.length) {
        var first = grid.querySelector('input[name="' + coverName + '"]');
        if (first) first.checked = true;
      }

      paintCover();

      var total = files.length + (isEdit ? existingKept() : 0);
      if (count) {
        count.textContent = total === 0
          ? 'No photos selected yet.'
          : total + ' of ' + MAX + ' photos selected' + (files.length ? ' (' + files.length + ' new)' : '') + '.';
      }
    }

    function paintCover() {
      document.querySelectorAll('.jb-photo').forEach(function (el) {
        var r = el.querySelector('input[type=radio]');
        el.classList.toggle('is-cover', !!(r && r.checked));
        var flag = el.querySelector('.jb-photo__flag');
        if (r && r.checked && !flag) {
          var b = document.createElement('span');
          b.className = 'jb-photo__flag';
          b.textContent = 'Cover';
          el.appendChild(b);
        } else if ((!r || !r.checked) && flag) {
          flag.remove();
        }
      });
    }

    input.addEventListener('change', function () {
      var incoming = Array.prototype.slice.call(input.files);
      var room = MAX - files.length - (isEdit ? existingKept() : 0);

      if (incoming.length > room) {
        alert('You can have at most ' + MAX + ' photos. Only the first ' + Math.max(room, 0) + ' were added.');
        incoming = incoming.slice(0, Math.max(room, 0));
      }

      files = files.concat(incoming);
      syncInput();
      render();
    });

    // Keep the counter honest when existing photos are unticked (edit form).
    document.querySelectorAll('input[name="existing_image_ids[]"]').forEach(function (cb) {
      cb.addEventListener('change', function () {
        var card = cb.closest('.jb-photo');
        if (card) card.style.opacity = cb.checked ? '1' : '.45';
        render();
      });
    });

    // Edit form only: translate the unified radio group into the two
    // fields the FormRequest expects.
    var form = input.closest('form');
    if (isEdit && form) {
      form.addEventListener('submit', function () {
        var chosen = document.querySelector('input[name="cover_choice"]:checked');
        if (!chosen) return;
        var parts = chosen.value.split(':');
        var target = parts[0] === 'new' ? 'cover_index' : 'cover_image_id';
        var hidden = form.querySelector('input[name="' + target + '"]');
        if (hidden) hidden.value = parts[1];
      });
    }

    render();
  })();
</script>
