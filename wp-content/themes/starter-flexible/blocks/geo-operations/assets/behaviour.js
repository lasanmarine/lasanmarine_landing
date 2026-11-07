// Geo Operations — a row in the list lights up its pin on the map.
import { hoverSelect } from '$lib/hover-select';

export const selector = '.geo';

export default (root) =>
	hoverSelect(root, { rows: '[data-geo-row]', targets: '[data-geo-pin]', events: ['mouseenter', 'focus', 'click'] });
