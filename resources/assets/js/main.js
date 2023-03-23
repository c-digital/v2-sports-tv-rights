function app () {
	return {
		showUserMenu: false,

		showMainMenu: (window.innerWidth > 800) ? true : false,

		photo: '',

        type: '',

        moreFields: '',

		search (input) {
            var input, filter, table, tr, td, i, j, visible;
            filter = input.value.toUpperCase();
            table = document.getElementById('table');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) {
                visible = false;
                td = tr[i].getElementsByTagName('td');

                for (j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        visible = true;
                    }
                }

                if (!tr[0]) {
                    tr[0].style.display = '';
                }

                if (visible === true) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        },

        confirmDelete (event, element) {
            event.preventDefault();

            title = document.getElementById('confirm_delete_text').value;
            confirmButtonText = document.getElementById('confirm_delete_accept').value;
            cancelButtonText = document.getElementById('confirm_delete_cancel').value;

            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                confirmButtonColor: 'black',
                cancelButtonText: cancelButtonText
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = element.href;
                }
            });
        },

        preview (value) {
			input = document.getElementById('photo');

		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (event) {
		            document.getElementById('photo-preview').setAttribute('src', event.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		},

        removePhoto () {
            this.photo = '';
            document.getElementById('photo-preview').src = document.getElementById('photo-url').value;
        },

        showFields() {
            this.moreFields = '';

            if (this.type == 'lineups' || this.type == 'referees' || this.type == 'stats' || this.type == 'heatMap' || this.type == 'score') {
                this.moreFields = `
                    <div class="mt-4">
                        <label for="fixture">Fixture</label>
                        <input type="text" name="fixture" required>
                    </div>
                `;
            }

            if (this.type == 'fixture' || this.type == 'score') {
                this.moreFields = `
                    <div class="mt-4">
                        <label for="date">Fecha</label>
                        <input type="date" name="date" required>
                    </div>
                `;
            }
        },

        reloadWithLeague() {
            league = document.getElementById('league').value;
            type = document.getElementById('type').value;

            url = window.location.protocol + '//' + window.location.host + window.location.pathname;

            if (league != '' && type != 'standings') {
                window.location.href = url  + '?league=' + league;
            }
        },

        reloadWithType() {
            league = document.getElementById('league').value;
            type = document.getElementById('type').value;

            url = window.location.protocol + '//' + window.location.host + window.location.pathname;

            if (type == 'standings') {
                if (document.getElementById('round-container')) {
                    document.getElementById('round-container').style.display = 'none';
                }

                if (document.getElementById('match-container')) {
                    document.getElementById('match-container').style.display = 'none';
                }
            }

            if (type != '' && type != 'standings') {
                window.location.href = url  + '?type=' + type + '&league=' + league;
            }
        },

        reloadWithRound() {
            league = document.getElementById('league').value;
            type = document.getElementById('type').value;
            round = document.getElementById('round').value;
            type = document.getElementById('type').value;

            url = window.location.protocol + '//' + window.location.host + window.location.pathname;

            if (type == 'standings') {
                if (document.getElementById('match-container')) {
                    document.getElementById('match-container').style.display = 'none';
                }
            }

            if (round != '' && type != 'fixture') {
                window.location.href = url  + '?type=' + type + '&league=' + league + '&round=' + round;
            }
        },

        copyToClipboard() {
            link = document.getElementById('link').value;
            navigator.clipboard.writeText(link);

            Swal.fire({
                title: 'Enlace copiado',
                icon: 'success',
                confirmButtonColor: 'black',
            })
        }
	}
}
