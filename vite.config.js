import path from 'path';
import glob from 'glob';
import { defineConfig } from 'vite';

const root = path.resolve(__dirname, 'client');
export default defineConfig({
	root: root,
	build: {
		outDir: path.resolve(__dirname, 'dist'),
		manifest: true,
		emptyOutDir: true,
		rollupOptions: {
			input: Array.prototype.concat(
				glob.sync('client/javascript/*.js'),
				glob.sync('client/styles/pages/*.css')),
			output: {
				entryFileNames: 'javascript/[name].js',
				chunkFileNames: 'javascript/[name].js',
				assetFileNames: 'assets/[name].[ext]'
			}
		}
	},
	resolve: {
		alias: {
		  	'css': path.resolve(__dirname, 'client', 'styles'),
		},
	}
});