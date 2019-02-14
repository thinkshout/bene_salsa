desc 'Install dependencies'
task :install do
    system 'bundle install'
system 'npm install -g browser-sync'
system 'npm install -g browserify'
system 'npm install -g watchify'
system 'npm install -g uglify-js'
system 'npm install jquery --save-dev'
end

# Change basetheme.dev to your site path
desc 'Running Browsersync'
task :browsersync do
    system 'browser-sync start --proxy "web.otfo.localhost" --files "css/*.css" --no-inject-changes'
end

desc 'Watch sass'
task :sasswatch do
    system 'sass -r sass-globbing --watch sass/styles.scss:css/salsa_forms.css'
end

desc 'Serve'
task :serve do
    threads = []
        %w{browsersync sasswatch browserify}.each do |task|
threads << Thread.new(task) do |devtask|
Rake::Task[devtask].invoke
end
end
threads.each {|thread| thread.join}
puts threads
end