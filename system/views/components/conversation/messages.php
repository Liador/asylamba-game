<?php
echo '<div class="component topic size2">';
	echo '<div class="head skin-5">';
		if (!empty(ASM::$cvm->get()->title)) {
			echo '<h2>' . ASM::$cvm->get()->title . '</h2>';
		}
	echo '</div>';
	echo '<div class="fix-body">';
		echo '<div class="body">';
			echo '<div class="message write">';
				echo '<img src="' . MEDIA . 'avatar/small/' . CTR::$data->get('playerInfo')->get('avatar') . '.png" alt="' . CTR::$data->get('playerInfo')->get('pseudo') . '" class="avatar" />';
				echo '<div class="content">';
					echo '<form action="' . Format::actionBuilder('writeconversation', ['conversation' => ASM::$cvm->get()->id]) . '" method="post">';
						echo '<div class="wysiwyg" data-id="new-message">';
							echo (new Parser())->getToolbar();
							echo '<textarea name="content" id="new-message"></textarea>';
						echo '</div>';

						echo '<button>Répondre</button>';
					echo '</form>';
				echo '</div>';
			echo '</div>';

			for ($i = 0; $i < ASM::$cme->size(); $i++) {
				$m = ASM::$cme->get($i);

				$status = ColorResource::getInfo($m->playerColor, 'status');
				$status = $status[$m->playerStatus - 1];

				if ($i != 0 AND ASM::$cme->get($i - 1)->dCreation > $dPlayerLastMessage AND $m->dCreation <= $dPlayerLastMessage) {
					echo '<div class="system-message">';
						echo 'Dernier message lu';
					echo '</div>';
				}

				if ($m->type == ConversationMessage::TY_STD) {
					echo '<div class="message">';
						echo '<a href="' . APP_ROOT . 'embassy/player-' . $m->rPlayer . '"><img src="' . MEDIA . 'avatar/medium/' . $m->playerAvatar . '.png" alt="' . $m->playerName . '" class="avatar" /></a>';
						echo '<div class="content">';
							echo '<p class="text">';
								echo $m->content;
							echo '</p>';
							echo '<p class="footer">';
								echo $status . ' ' . $m->playerName . ', ';
								echo Chronos::transform($m->dCreation);
							echo '</p>';
						echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="system-message">';
						echo $m->content;
					echo '</div>';
				}
			}
		echo '</div>';
	echo '</div>';
echo '</div>';