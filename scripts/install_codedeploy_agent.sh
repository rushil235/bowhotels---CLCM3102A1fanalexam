#!/bin/bash
# Install CodeDeploy agent
yum install -y ruby
yum install -y wget
wget https://github.com/aws/aws-codedeploy-agent/releases/download/latest/codedeploy-agent-1.7.1-1.x86_64.rpm
rpm -i codedeploy-agent-1.7.1-1.x86_64.rpm
systemctl enable codedeploy-agent
systemctl start codedeploy-agent
