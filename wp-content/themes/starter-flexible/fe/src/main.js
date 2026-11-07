import './main.scss';
import './site.scss';
import './runtime/boot';

if (import.meta.env.DEV) {
	// Production emits each block's stylesheet on its own and PHP inlines the
	// ones a page uses; the dev server only serves this graph, so pull them in.
	import('./styles/blocks.scss');
}
