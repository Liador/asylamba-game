<?php
echo '<div class="component size2 new-message">';
	echo '<div class="head skin-5">';
		echo '<h2>Démarrer une nouvelle conversation</h2>';
	echo '</div>';
	echo '<div class="fix-body">';
		echo '<div class="body">';
			echo '<form action="' . Format::actionBuilder('startconversation') . '" method="post">';
				echo '<p>';
					echo 'Destinataire';
				echo '</p>';
				echo '<p class="input input-text">';
					echo '<input class="autocomplete-hidden" name="recipients" type="hidden" />';
					echo '<input autocomplete="off" class="autocomplete-player ac_input" name="name" placeholder="Destinataire" type="text" />';
				echo '</p>';

				echo '<p>';
					echo 'Message';
				echo '</p>';
				echo '<p class="input input-area">';
					echo '<span class="wysiwyg" data-id="new-message-wysiwyg">';
						echo (new Parser())->getToolbar();
						echo '<textarea name="content" id="new-message-wysiwyg"></textarea>';
					echo '</span>';
				echo '</p>';

				echo '<p><button>Démarrer la conversation</button></p>';
			echo '</form>';
		echo '</div>';
	echo '</div>';
echo '</div>';