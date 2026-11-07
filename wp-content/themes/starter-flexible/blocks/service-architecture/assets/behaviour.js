// Service Architecture — a row in the list brings up its slide.
import { hoverSelect } from '$lib/hover-select';

export const selector = '[data-service-arch]';

export default (root) => hoverSelect(root, { rows: '[data-service-row]', targets: '[data-service-slide]' });
