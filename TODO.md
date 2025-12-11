# Performance Optimization TODO

## High Priority (TTFB Reduction)

- [x] Create cache table in database for API results
- [x] Create Cache model for managing cached data
- [x] Modify HomeController to use cached API results instead of live calls
- [x] Fix footer.php CSS path (wrong relative path)

## Medium Priority (Page Weight Reduction)

- [ ] Analyze and remove unused CSS/JS files
- [ ] Combine and minify CSS files
- [ ] Optimize images (compress, lazy load)
- [ ] Enable more aggressive compression in .htaccess

## Low Priority (Further Optimizations)

- [ ] Implement lazy loading for images
- [ ] Add database query optimizations (indexes if needed)
- [ ] Review and optimize other controllers for similar bottlenecks

## New Optimizations (High Priority)

- [ ] Cache database queries in HomeController for moocs, livres, and actualites
- [ ] Optimize Cache::createTableIfNotExists() to avoid running on every request
- [ ] Fix inconsistent footer.php include paths in views (e.g., documents_view.php)

## Testing

- [ ] Test TTFB reduction to <1s
- [ ] Test page weight <1MB
- [ ] Verify site functionality after changes
