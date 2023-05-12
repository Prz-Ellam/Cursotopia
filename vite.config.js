import path from 'path';
import glob from 'glob';
import { defineConfig } from 'vite';

const root = path.resolve(__dirname, 'client');
export default defineConfig({
	root: root,
	build: {
		outDir: path.resolve(__dirname, 'public', 'dist'),
		manifest: true,
		emptyOutDir: true,
		sourcemap: true,
		rollupOptions: {
			input: Array.prototype.concat(
				glob.sync('client/javascript/*.js'),
				glob.sync('client/styles/pages/*.css')),
			output: {
				entryFileNames: 'javascript/[hash].js',
				chunkFileNames: 'javascript/[hash].js',
				assetFileNames: 'assets/[hash].[ext]'
			}
		}
	},
	resolve: {
		alias: {
		  	'css': path.resolve(__dirname, 'client', 'styles'),
			'@': path.resolve(__dirname, 'client', 'javascript')
		},
	}
});