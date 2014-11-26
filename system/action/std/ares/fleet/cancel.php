<?php
include_once ARES;
include_once GAIA;
include_once ZEUS;
# send a fleet to loot a place

# int commanderid 			id du commandant à envoyer
# int placeid				id de la place attaquée

$commanderId = Utils::getHTTPData('commanderid');

if ($commanderId !== FALSE) {
	$S_COM1 = ASM::$com->getCurrentSession();
	ASM::$com->newSession(ASM_UMODE);
	ASM::$com->load(array('c.id' => $commanderId, 'c.rPlayer' => CTR::$data->get('playerId')));

		if (ASM::$com->size() > 0) {
			$commander = ASM::$com->get();

			$interval = Utils::interval($commander->dArrival, Utils::now(), 's');
			$dStart = new DateTime(Utils::now());
			$dStart->modify('-' . $interval . ' second');

			$duration = Utils::interval($commander->dStart, $commander->dArrival, 's');

			$dArrival = new DateTime($dStart->format('Y-m-d H:i:s'));
			$dArrival->modify('+' . $duration . ' second');

			$rDestinationPlace = $commander->rDestinationPlace;
			$commander->rDestinationPlace = $commander->rStartPlace;
			$commander->rStartPlace = $commander->rDestinationPlace;
			$startPlaceName = $commander->startPlaceName;
			$commander->startPlaceName = $commander->destinationPlaceName;
			$commander->destinationPlacename = $startPlaceName;
			$commander->dStart = $dStart->format('Y-m-d H:i:s');
			$commander->dArrival = $dArrival->format('Y-m-d H:i:s');
			$commander->travelType = 3;

			if (CTR::$data->exist('playerEvent') && $commander->rPlayer == CTR::$data->get('playerId')) {
				for ($i = 0; $i < CTR::$data->get('playerEvent')->size(); $i++) {
					if (CTR::$data->get('playerEvent')->get($i)->get('eventInfo')->get('id') == $commander->id) {
						CTR::$data->get('playerEvent')->remove($i);
					}
				}
				// CTR::$data->get('playerEvent')->add(
				// 	$this->dArrival,
				// 	EVENT_OUTGOING_ATTACK,
				// 	$this->id,
				// 	$commander->getEventInfo()
				// );
			}

			CTR::$alert->add('Déplacement annulé.', ALERT_STD_SUCCESS);

			if (CTR::$get->exist('redirect')) {
				CTR::redirect('map/place-' . CTR::$get->get('redirect'));
			}
		} else {
			CTR::$alert->add('Ce commandant ne vous appartient pas ou n\'existe pas.', ALERT_STD_ERROR);
		}
	ASM::$com->changeSession($S_COM1);
} else {
	CTR::$alert->add('Manque de précision sur le commandant ou la position.', ALERT_STD_ERROR);
}