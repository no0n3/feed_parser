(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('index.html',
    '<!DOCTYPE html>\n' +
    '<html>\n' +
    '<head>\n' +
    '    <link href="../public/css/styles.css" rel="stylesheet" type="text/css">\n' +
    '</head>\n' +
    '<body data-ng-app="app">\n' +
    '\n' +
    '    <div class="app-main">\n' +
    '        <ng-view></ng-view>\n' +
    '    </div>\n' +
    '\n' +
    '<script src="../public/js/all.js"></script>\n' +
    '</body>\n' +
    '</html>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/home/home.html',
    '<h1>PLAY GAMES</h1>\n' +
    '{{ msg }}\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/login/login.html',
    '<h1>LOGIN</h1>\n' +
    '<form name="form" novalidate class="simple-form">\n' +
    '    <label>E-mail: <input type="text" name="email" ng-model="user.email" ng-disabled="loading" required/></label><br />\n' +
    '    <label>Password: <input type="password" name="password" ng-model="user.password" ng-disabled="loading" required/></label><br />\n' +
    '    <br />\n' +
    '    <input type="submit" ng-disabled="loading" ng-click="login(form)" value="Login" />\n' +
    '    <button ng-disabled="loading" ng-click="goToSignup()">sign up</button>\n' +
    '</form>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/signup/signup.html',
    '<h1>SIGN UP</h1>\n' +
    '<form name="form" novalidate class="simple-form">\n' +
    '    <label>Name <input type="text" name="name" ng-model="user.name" ng-disabled="loading" required/></label><br />\n' +
    '    <label>E-mail: <input type="text" name="email" ng-model="user.email" ng-disabled="loading" required/></label><br />\n' +
    '    <label>Password: <input type="password" name="password" ng-model="user.password" ng-disabled="loading" required/></label><br />\n' +
    '    <br />\n' +
    '    <input type="submit" ng-disabled="loading" ng-click="signup(form)" value="Sign up" />\n' +
    '    <button ng-disabled="loading" ng-click="goToLogin()">login</button>\n' +
    '</form>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/add.html',
    '<div data-ng-if="true === added">\n' +
    '    <div>Feed source successlly added</div>\n' +
    '    <div>\n' +
    '        <button data-ng-click="addAnother()">add another</button>\n' +
    '        <button data-ng-click="viewAll()">view all</button>\n' +
    '    </div>\n' +
    '</div>\n' +
    '<div data-ng-if="false === added">\n' +
    '    <div>ADD fs XX</div>\n' +
    '    <form name="form" novalidate class="simple-form">\n' +
    '        <div>\n' +
    '            <select data-ng-model="source.type" ng-options="x for x in types"></select>\n' +
    '        </div>\n' +
    '        <div data-ng-if="\'type_rss\' === source.type">\n' +
    '            <div>\n' +
    '                <label>Rss Link: <input type="text" name="rss_link" ng-model="source.rss_link" ng-disabled="loading" required/></label>\n' +
    '            </div>\n' +
    '        </div>\n' +
    '        <div data-ng-if="\'type_twitter\' === source.type">\n' +
    '            <div>\n' +
    '                <label>Woid: <input type="text" name="woid" ng-model="source.woid" ng-disabled="loading" required/></label>\n' +
    '            </div>\n' +
    '        </div>\n' +
    '\n' +
    '        <button ng-disabled="loading" ng-click="create()">create</button>\n' +
    '    </form>\n' +
    '    <div>{{ source | json }}</div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/feed_item.html',
    '<div class="feed-item-cont">\n' +
    '    xxx\n' +
    '    <div data-ng-if="\'type_rss\' === source.type">\n' +
    '        <div><span class="field-title">Id:</span> {{ source.id}}</div>\n' +
    '        <div><span class="field-title">Title:</span> {{ source.title}}</div>\n' +
    '        <div><span class="field-title">Link:</span> <a data-ng-href="{{ source.link}}">{{ source.link}}</a></div>\n' +
    '        <div><span class="field-title">Publish Time:</span> {{ source.publish_time}}</div>\n' +
    '        <div><span class="field-title">Created At:</span> {{ source.created_at}}</div>\n' +
    '        <div><span class="field-title">Updated At:</span> {{ source.updated_at}}</div>\n' +
    '    </div>\n' +
    '    <div data-ng-if="\'type_twitter\' === source.type">\n' +
    '        <div><span class="field-title">Id:</span> {{ source.id}}</div>\n' +
    '        <div><span class="field-title">Tweet Id:</span> {{ source.tweet_id}}</div>\n' +
    '        <div><span class="field-title">Link:</span> <a data-ng-href="{{ source.link}}">{{ source.link}}</a></div>\n' +
    '        <div><span class="field-title">Publish Time:</span> {{ source.publish_time}}</div>\n' +
    '        <div><span class="field-title">Created At:</span> {{ source.created_at}}</div>\n' +
    '        <div><span class="field-title">Updated At:</span> {{ source.updated_at}}</div>\n' +
    '    </div>\n' +
    '    <div class="feed-item-btns-cont">\n' +
    '        <a data-ng-href="{{ siteDomain + \'feed-source/\' + source.type + \'/\' + source.source.id}}">view source</a>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/feed_list.html',
    '<div data-ng-include="headerUrl"></div>\n' +
    '<h3>LIST FEED</h3>\n' +
    '\n' +
    '<div data-ng-if="true === loading">\n' +
    '    Loading ...\n' +
    '</div>\n' +
    '<div data-ng-if="false === loading">\n' +
    '    <div data-ng-repeat="source in sources" class="feed-item">\n' +
    '        <feed-item item="source"></feed-item>\n' +
    '    </div>\n' +
    '    <div data-ng-show="1 < total_pages">\n' +
    '        <button data-ng-click="first()">first</button> <button data-ng-click="prev()">prev</button> | {{ page }} of {{ total_pages }} | <button data-ng-click="next()">next</button> <button data-ng-click="last()">last</button>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/feed_source_item.html',
    '<div class="feed-item-cont">\n' +
    '    <div data-ng-if="\'type_rss\' === source.type">\n' +
    '        <div><span class="field-title">Title:</span> {{ source.title}}</div>\n' +
    '        <div><span class="field-title">Link:</span> <a data-ng-href="{{ source.link}}">{{ source.link}}</a></div>\n' +
    '        <div><span class="field-title">Created At:</span> {{ source.created_at}}</div>\n' +
    '        <div><span class="field-title">Updated At:</span> {{ source.updated_at}}</div>\n' +
    '    </div>\n' +
    '    <div data-ng-if="\'type_twitter\' === source.type">\n' +
    '        <div><span class="field-title">Woid:</span> {{ source.woid}}</div>\n' +
    '        <div><span class="field-title">Created At:</span> {{ source.created_at}}</div>\n' +
    '        <div><span class="field-title">Updated At:</span> {{ source.updated_at}}</div>\n' +
    '    </div>\n' +
    '    <div class="feed-item-btns-cont">\n' +
    '        <a data-ng-href="#">show all feeds</a>\n' +
    '        <a data-ng-href="#">edit</a>\n' +
    '        <button data-ng-click="deleteFeedSourceItem({\'type\': source.type, \'id\': source.id})">delete</button>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/sources_list.html',
    '<div data-ng-include="headerUrl"></div>\n' +
    '<h3>LIST SOURCES</h3>\n' +
    '<div><a data-ng-href="{{ siteDomain + \'feed-source/add\' }}">add new feed source</a></div>\n' +
    '<div data-ng-if="true === loading">\n' +
    '    Loading ...\n' +
    '</div>\n' +
    '<div data-ng-if="false === loading">\n' +
    '    <div data-ng-repeat="source in sources" class="feed-item" data-ng-show="!source.deleted">\n' +
    '        <feed-source-item item="source"></feed-source-item>\n' +
    '    </div>\n' +
    '    <div data-ng-show="1 < total_pages">\n' +
    '        <button data-ng-click="first()">first</button> <button data-ng-click="prev()">prev</button> | {{ page }} of {{ total_pages }} | <button data-ng-click="next()">next</button> <button data-ng-click="last()">last</button>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/view.html',
    '<div data-ng-include="headerUrl"></div>\n' +
    '<div data-ng-if="true === loading">\n' +
    '    Loading ...\n' +
    '</div>\n' +
    '<div data-ng-if="false === loading">\n' +
    '    <div class="feed-item">\n' +
    '        <feed-item item="source"></feed-item>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/feed/views/view_source.html',
    '<div data-ng-include="headerUrl"></div>\n' +
    '<div data-ng-if="true === loading">\n' +
    '    Loading ...\n' +
    '</div>\n' +
    '<div data-ng-if="false === loading">\n' +
    '    <div data-ng-repeat="source in sources" class="feed-item">\n' +
    '        <feed-source-item item="source"></feed-source-item>\n' +
    '    </div>\n' +
    '</div>\n' +
    '');
}]);
})();

(function(module) {
try {
  module = angular.module('app.templates');
} catch (e) {
  module = angular.module('app.templates', []);
}
module.run(['$templateCache', function($templateCache) {
  $templateCache.put('app/header/views/main.html',
    '<div>\n' +
    '    <a data-ng-href="{{ siteDomain + \'feed-source/list\' }}">feed sources</a>\n' +
    '    <a data-ng-href="{{ siteDomain + \'feed/list\' }}">feeds</a>\n' +
    '</div>\n' +
    '');
}]);
})();
